<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DesignController extends Controller
{
    public function saveDesign(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'form_data' => 'required|string',
                'action' => 'required|in:save,submit',
                'logo_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'license_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
                'additional_file_*' => 'nullable|file|max:10240'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Validation failed',
                    'details' => $validator->errors()
                ], 400);
            }

            // Decode form data
            $formData = json_decode($request->input('form_data'), true);
            
            if (!$formData) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid form data'
                ], 400);
            }

            // Start database transaction
            DB::beginTransaction();

            try {
                // Save user information
                $userId = $this->saveUserInfo($formData['personalInfo']);
                
                // Save business information
                $businessId = $this->saveBusinessInfo($formData['businessInfo'], $userId);
                
                // Save design information
                $designId = $this->saveDesignInfo($formData['designInfo'], $businessId);
                
                // Save 3D design data
                $this->save3DDesignData($formData['design3D'], $designId);
                
                // Handle file uploads
                $this->handleFileUploads($request, $designId);
                
                // Save order summary
                $this->saveOrderSummary($formData['orderSummary'], $designId);
                
                // Save metadata
                $this->saveMetadata($formData['metadata'], $designId);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'design_id' => $designId,
                    'message' => 'Design saved successfully'
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function saveUserInfo($personalInfo)
    {
        $user = DB::table('users')->insertGetId([
            'name' => $personalInfo['name'],
            'email' => $personalInfo['email'],
            'phone' => $personalInfo['phone'],
            'password' => bcrypt($personalInfo['password']),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $user;
    }

    private function saveBusinessInfo($businessInfo, $userId)
    {
        $business = DB::table('businesses')->insertGetId([
            'user_id' => $userId,
            'business_name' => $businessInfo['businessName'],
            'business_type' => $businessInfo['businessType'],
            'business_type_other' => $businessInfo['businessTypeOther'],
            'address' => $businessInfo['address'],
            'city' => $businessInfo['city'],
            'country' => $businessInfo['country'],
            'website' => $businessInfo['website'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $business;
    }

    private function saveDesignInfo($designInfo, $businessId)
    {
        $design = DB::table('designs')->insertGetId([
            'business_id' => $businessId,
            'design_option' => $designInfo['designOption'],
            'business_type' => $designInfo['businessType'],
            'clothing_pieces' => json_encode($designInfo['clothingPieces']),
            'sizes' => json_encode($designInfo['sizes']),
            'colors' => json_encode($designInfo['colors']),
            'patterns' => json_encode($designInfo['patterns']),
            'logos' => json_encode($designInfo['logos']),
            'texts' => json_encode($designInfo['texts']),
            'design_notes' => $designInfo['designNotes'],
            'priority' => $designInfo['priority'],
            'delivery_preference' => $designInfo['delivery'],
            'requirements' => json_encode($designInfo['requirements']),
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $design;
    }

    private function save3DDesignData($design3D, $designId)
    {
        if (!$design3D) return;

        DB::table('design_3d_data')->insert([
            'design_id' => $designId,
            'model_data' => json_encode($design3D['modelData']),
            'camera_position' => json_encode($design3D['cameraPosition']),
            'lighting_settings' => json_encode($design3D['lightingSettings']),
            'render_settings' => json_encode($design3D['renderSettings']),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    private function handleFileUploads($request, $designId)
    {
        $uploadPath = 'designs/' . $designId . '/';
        
        // Handle logo file
        if ($request->hasFile('logo_file')) {
            $logoFile = $request->file('logo_file');
            $logoPath = $logoFile->store($uploadPath . 'logo', 'public');
            
            DB::table('design_files')->insert([
                'design_id' => $designId,
                'file_type' => 'logo',
                'file_path' => $logoPath,
                'original_name' => $logoFile->getClientOriginalName(),
                'file_size' => $logoFile->getSize(),
                'mime_type' => $logoFile->getMimeType(),
                'created_at' => now()
            ]);
        }

        // Handle business license file
        if ($request->hasFile('license_file')) {
            $licenseFile = $request->file('license_file');
            $licensePath = $licenseFile->store($uploadPath . 'license', 'public');
            
            DB::table('design_files')->insert([
                'design_id' => $designId,
                'file_type' => 'license',
                'file_path' => $licensePath,
                'original_name' => $licenseFile->getClientOriginalName(),
                'file_size' => $licenseFile->getSize(),
                'mime_type' => $licenseFile->getMimeType(),
                'created_at' => now()
            ]);
        }

        // Handle additional files
        $additionalFiles = $request->allFiles();
        foreach ($additionalFiles as $key => $file) {
            if (strpos($key, 'additional_file_') === 0) {
                $filePath = $file->store($uploadPath . 'additional', 'public');
                
                DB::table('design_files')->insert([
                    'design_id' => $designId,
                    'file_type' => 'additional',
                    'file_path' => $filePath,
                    'original_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'created_at' => now()
                ]);
            }
        }
    }

    private function saveOrderSummary($orderSummary, $designId)
    {
        DB::table('order_summaries')->insert([
            'design_id' => $designId,
            'total_pieces' => $orderSummary['totalPieces'],
            'total_varieties' => $orderSummary['totalVarieties'],
            'estimated_cost' => $orderSummary['estimatedCost'],
            'estimated_delivery_days' => $orderSummary['estimatedDelivery'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    private function saveMetadata($metadata, $designId)
    {
        DB::table('design_metadata')->insert([
            'design_id' => $designId,
            'created_at_timestamp' => $metadata['createdAt'],
            'user_agent' => $metadata['userAgent'],
            'screen_resolution' => $metadata['screenResolution'],
            'form_version' => $metadata['formVersion'],
            'design_complete' => $metadata['designComplete'],
            'notes_complete' => $metadata['notesComplete'],
            'created_at' => now()
        ]);
    }

    public function getDesign($id)
    {
        try {
            $design = DB::table('designs')
                ->join('businesses', 'designs.business_id', '=', 'businesses.id')
                ->join('users', 'businesses.user_id', '=', 'users.id')
                ->leftJoin('order_summaries', 'designs.id', '=', 'order_summaries.design_id')
                ->leftJoin('design_3d_data', 'designs.id', '=', 'design_3d_data.design_id')
                ->leftJoin('design_metadata', 'designs.id', '=', 'design_metadata.design_id')
                ->where('designs.id', $id)
                ->select(
                    'designs.*',
                    'businesses.*',
                    'users.name as user_name',
                    'users.email as user_email',
                    'users.phone as user_phone',
                    'order_summaries.*',
                    'design_3d_data.*',
                    'design_metadata.*'
                )
                ->first();

            if (!$design) {
                return response()->json([
                    'success' => false,
                    'error' => 'Design not found'
                ], 404);
            }

            // Get files
            $files = DB::table('design_files')
                ->where('design_id', $id)
                ->get();

            $design->files = $files;

            return response()->json([
                'success' => true,
                'design' => $design
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllDesigns()
    {
        try {
            $designs = DB::table('designs')
                ->join('businesses', 'designs.business_id', '=', 'businesses.id')
                ->join('users', 'businesses.user_id', '=', 'users.id')
                ->leftJoin('order_summaries', 'designs.id', '=', 'order_summaries.design_id')
                ->select(
                    'designs.id',
                    'designs.status',
                    'designs.priority',
                    'designs.created_at',
                    'businesses.business_name',
                    'businesses.business_type',
                    'users.name as user_name',
                    'users.email as user_email',
                    'order_summaries.total_pieces',
                    'order_summaries.estimated_cost'
                )
                ->orderBy('designs.created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'designs' => $designs
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
}
