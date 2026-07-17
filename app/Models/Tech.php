<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Tech
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string $iconUrl
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection|Experience[] $experienceTechExperiences
 * @property Collection|ExperienceTech[] $experienceTeches
 */
class Tech extends Model
{
    protected $table = 'techs';

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
        'name',
        'iconurl',
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
            'name' => 'string',
            'iconUrl' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * @return HasMany<ExperienceTech, $this>
     */
    public function experienceTeches(): HasMany
    {
        return $this->hasMany(ExperienceTech::class, 'tech_id', 'uuid');
    }

    /**
     * @return BelongsToMany<Experience, $this>
     */
    public function experienceTechExperiences(): BelongsToMany
    {
        return $this->belongsToMany(Experience::class, 'experience_tech', 'tech_id', 'experience_id', 'uuid', 'uuid')
            ->withPivot('experience_id', 'tech_id')
            ->withTimestamps();
    }
}
