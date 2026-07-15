<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ExperienceTech
 *
 * @property int $id
 * @property string $experience_id
 * @property string $tech_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Experience $experience
 * @property Tech $tech
 */
class ExperienceTech extends Model
{
    protected $table = 'experience_tech';

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
        'experience_id',
        'tech_id',
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
            'experience_id' => 'string',
            'tech_id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Experience, $this>
     */
    public function experience(): BelongsTo
    {
        return $this->belongsTo(Experience::class, 'experience_id', 'uuid');
    }

    /**
     * @return BelongsTo<Tech, $this>
     */
    public function tech(): BelongsTo
    {
        return $this->belongsTo(Tech::class, 'tech_id', 'uuid');
    }
}
