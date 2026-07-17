<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Experience
 *
 * @property int $id
 * @property string $uuid
 * @property string $title
 * @property string $problem
 * @property string $solution
 * @property string $learned
 * @property string $category
 * @property string $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Product $product
 * @property Collection|Tech[] $experienceTechTechs
 * @property Collection|ExperienceTech[] $experienceTeches
 */
class Experience extends Model
{
    protected $table = 'experiences';

    /**
     * @var string
     */
    protected $connection = 'mysql';

    protected $primaryKey = 'id';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'uuid',
        'title',
        'problem',
        'solution',
        'learned',
        'category',
        'product_id',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'uuid' => 'string',
            'title' => 'string',
            'problem' => 'string',
            'solution' => 'string',
            'learned' => 'string',
            'category' => 'string',
            'product_id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * @return HasMany<ExperienceTech, $this>
     */
    public function experienceTeches(): HasMany
    {
        return $this->hasMany(ExperienceTech::class, 'experience_id', 'uuid');
    }

    /**
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'uuid');
    }

    /**
     * @return BelongsToMany<Tech, $this>
     */
    public function experienceTechTechs(): BelongsToMany
    {
        return $this->belongsToMany(Tech::class, 'experience_tech', 'experience_id', 'tech_id', 'uuid', 'uuid')
            ->withPivot('experience_id', 'tech_id')
            ->withTimestamps();
    }
}
