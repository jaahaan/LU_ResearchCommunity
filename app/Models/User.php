<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department',
        'department_id',
        'designation',
        'image',
        'about',
        'skills',
        'interests',
        'honors_and_awards',
        'isVerifiedCode',
        'isEmailVerified',
        'isVerifiedByAdmin',
        'userType',
        'otp',
        'twoFactorCode',
        'expires_at',
    ];
    public function setPasswordAttribute($password)
    {
        if ($password !== null) {
            if (is_null(request()->bcrypt)) {
                $this->attributes['password'] = bcrypt($password);
            } else {
                $this->attributes['password'] = $password;
            }
        }
    }
    // public function setPasswordAttribute($password){
    //     $this->attributes['password'] = encrypt($password);
    // }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // public function academies(): HasMany{
    //     return $this->hasMany(Academy::class, 'club_id');
    // }
    // public function memberOfClubs(): HasMany
    // {
    //     return $this->hasMany(ClubPlayer::class, 'player_id');
    // }
    // public function teams(): HasMany{
    //     return $this->hasMany(Team::class, 'owner_id','id');
    // }
    // public function clubPlayers(): HasMany{
    //     return $this->hasMany(ClubPlayer::class, 'club_owner_id');
    // }
    // public function tournaments(): HasMany
    // {
    //     return $this->hasMany(Tournament::class, 'organizer_id', 'id');
    // }
    // public function turnament_club(): HasMany
    // {
    //     return $this->hasMany(TournamentTeam::class, 'team_id', 'id');
    // }
    // public function memberOfTeams(): HasMany
    // {
    //     return $this->hasMany(TeamPlayer::class, 'player_id');
    // }
    // public function clubMembers(): BelongsToMany
    // {
    //     return $this->belongsToMany(User::class, 'club_players', 'club_owner_id', 'player_id');
    // }


}
