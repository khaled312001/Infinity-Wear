<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ThreeDModelController extends Controller
{
    /**
     * Display the 3D model viewer
     */
    public function show()
    {
        return view('3d-model-viewer');
    }

    /**
     * Get the OBJ file content
     */
    public function getObjFile()
    {
        $filePath = public_path('images/FinalBaseMesh.obj');
        
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $content = file_get_contents($filePath);
        
        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type');
    }

    /**
     * Get model information
     */
    public function getModelInfo()
    {
        return response()->json([
            'name' => 'FinalBaseMesh.obj',
            'vertices' => 24461,
            'triangles' => 48918,
            'size' => [
                'x' => 11.69,
                'y' => 20.74,
                'z' => 3.77
            ],
            'volume' => 120.08,
            'surface' => 267.18,
            'file_size' => filesize(public_path('images/FinalBaseMesh.obj'))
        ]);
    }

}