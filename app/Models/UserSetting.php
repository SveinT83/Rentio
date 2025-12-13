<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class UserSetting extends Model
    {
        protected $fillable = ['show_email', 'show_tel', 'preferred_contact'];
    }
