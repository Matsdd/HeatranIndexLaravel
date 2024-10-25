<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'card_user_favorite');
    }

}
