<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'message',
        'status',
        'read_at',
        'replied_at',
        'admin_notes',
        'ip_address',
        'user_agent',
        'contact_type', // 'inquiry', 'custom'
        'assigned_to', // 'marketing', 'sales', 'both'
        'priority', // 'low', 'medium', 'high'
        'source', // 'website', 'phone', 'email', 'referral'
        'tags',
        'follow_up_date',
        'last_contact_date',
        'contact_count',
        'is_archived',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
        'follow_up_date' => 'datetime',
        'last_contact_date' => 'datetime',
        'tags' => 'array',
        'is_archived' => 'boolean',
        'contact_count' => 'integer'
    ];

    // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeInquiry($query)
    {
        return $query->where('contact_type', 'inquiry');
    }

    public function scopeCustom($query)
    {
        return $query->where('contact_type', 'custom');
    }

    public function scopeForMarketing($query)
    {
        return $query->whereIn('assigned_to', ['marketing', 'both']);
    }

    public function scopeForSales($query)
    {
        return $query->whereIn('assigned_to', ['sales', 'both']);
    }

    public function scopeNotArchived($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeBySource($query, $source)
    {
        return $query->where('source', $source);
    }

    public function scopeByTags($query, $tags)
    {
        return $query->whereJsonContains('tags', $tags);
    }

    // Methods
    public function markAsRead()
    {
        $this->update([
            'status' => 'read',
            'read_at' => now()
        ]);
    }

    public function markAsReplied()
    {
        $this->update([
            'status' => 'replied',
            'replied_at' => now()
        ]);
    }

    public function markAsClosed()
    {
        $this->update(['status' => 'closed']);
    }

    public function archive()
    {
        $this->update(['is_archived' => true]);
    }

    public function unarchive()
    {
        $this->update(['is_archived' => false]);
    }

    public function incrementContactCount()
    {
        $this->increment('contact_count');
        $this->update(['last_contact_date' => now()]);
    }

    public function assignTo($type)
    {
        $this->update(['assigned_to' => $type]);
    }

    public function setPriority($priority)
    {
        $this->update(['priority' => $priority]);
    }

    public function addTag($tag)
    {
        $tags = $this->tags ?? [];
        if (!in_array($tag, $tags)) {
            $tags[] = $tag;
            $this->update(['tags' => $tags]);
        }
    }

    public function removeTag($tag)
    {
        $tags = $this->tags ?? [];
        $tags = array_diff($tags, [$tag]);
        $this->update(['tags' => array_values($tags)]);
    }

    public function setFollowUpDate($date)
    {
        $this->update(['follow_up_date' => $date]);
    }

    // Accessors
    public function getPriorityBadgeAttribute()
    {
        return match($this->priority) {
            'high' => 'danger',
            'medium' => 'warning',
            'low' => 'success',
            default => 'secondary'
        };
    }

    public function getPriorityTextAttribute()
    {
        return match($this->priority) {
            'high' => 'عالي',
            'medium' => 'متوسط',
            'low' => 'منخفض',
            default => 'غير محدد'
        };
    }

    public function getSourceTextAttribute()
    {
        return match($this->source) {
            'website' => 'الموقع الإلكتروني',
            'phone' => 'الهاتف',
            'email' => 'البريد الإلكتروني',
            'referral' => 'إحالة',
            default => 'غير محدد'
        };
    }

    public function getAssignedToTextAttribute()
    {
        return match($this->assigned_to) {
            'marketing' => 'فريق التسويق',
            'sales' => 'فريق المبيعات',
            'both' => 'كلا الفريقين',
            default => 'غير محدد'
        };
    }

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
