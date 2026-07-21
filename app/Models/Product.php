<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'brand',
        'new_price',     // price ki jagah new_price
        'old_price',
        'stock',
        'description',
        'image',
        'status',
        'featured',

        // Gift & Mood Fields
        'mood_id',
        'gift_for',
        'occasion',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function mood()
    {
        return $this->belongsTo(Mood::class);
    }
    
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // ========== ACCESSORS ==========
    
    public function getGiftForLabelAttribute()
    {
        $labels = [
            'Mother' => '👩 Mother',
            'Father' => '👨 Father',
            'Brother' => '👦 Brother',
            'Sister' => '👧 Sister',
            'Friend' => '👫 Friend',
            'Husband' => '💑 Husband',
            'Wife' => '💑 Wife',
            'Son' => '👦 Son',
            'Daughter' => '👧 Daughter',
            'Grandmother' => '👵 Grandmother',
            'Grandfather' => '👴 Grandfather'
        ];
        return $labels[$this->gift_for] ?? $this->gift_for;
    }

    public function getOccasionLabelAttribute()
    {
       $labels = [
    'Birthday'    => '🎂 Birthday',
    'Anniversary' => '💍 Anniversary',
    'Eid'         => '🕌 Eid',
    'Graduation'  => '🎓 Graduation',
    'Wedding'     => '💒 Wedding',
];
        return $labels[$this->occasion] ?? $this->occasion;
    }

    public function getMoodLabelAttribute()
    {
        if ($this->mood) {
            return $this->mood->icon . ' ' . $this->mood->name;
        }
        return null;
    }

    public function getMoodColorAttribute()
    {
        if ($this->mood) {
            return $this->mood->color;
        }
        return '#6c757d';
    }

    // ========== SCOPES ==========
    
    public function scopeIsGift($query)
    {
        return $query->whereNotNull('gift_for')->orWhereNotNull('occasion');
    }

    public function scopeByMood($query, $moodId)
    {
        return $query->where('mood_id', $moodId);
    }

    public function scopeByOccasion($query, $occasion)
    {
        return $query->where('occasion', $occasion);
    }

    public function scopeByGiftFor($query, $giftFor)
    {
        return $query->where('gift_for', $giftFor);
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('new_price', [$min, $max]);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    // ========== HELPER METHODS ==========
    
    public function isGift()
    {
        return !is_null($this->gift_for) || !is_null($this->occasion);
    }

    public function hasMood()
    {
        return !is_null($this->mood_id);
    }

    public function getSalePercentageAttribute()
    {
        if ($this->old_price && $this->old_price > 0) {
            return round((($this->old_price - $this->new_price) / $this->old_price) * 100);
        }
        return 0;
    }

    public function inStock()
    {
        return $this->stock > 0;
    }

    public function getStockStatusAttribute()
    {
        if ($this->stock > 10) {
            return 'In Stock';
        } elseif ($this->stock > 0) {
            return 'Low Stock';
        } else {
            return 'Out of Stock';
        }
    }

    public function getStockBadgeClassAttribute()
    {
        if ($this->stock > 10) {
            return 'success';
        } elseif ($this->stock > 0) {
            return 'warning';
        } else {
            return 'danger';
        }
    }
}