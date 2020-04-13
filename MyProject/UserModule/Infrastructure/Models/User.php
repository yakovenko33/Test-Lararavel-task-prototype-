<?php


namespace MyProject\UserModule\Infrastructure\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    /**
     * @var integer
     */
    const STATUS_ACTIVE = 1;

    /**
     * @var integer
     */
    const STATUS_BLOCKED = 0;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'status'
    ];

    /**
     * @return array
     */
    public function jwtToArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
        ];
    }

    /**
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany("MyProject\UserModule\Models\Message");
    }
}
