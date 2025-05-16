<?php

namespace App\Models\Notify;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory,SoftDeletes,CascadeSoftDeletes;

    protected $table = 'public_mail';
    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['files'];
    protected $fillable = ['subject', 'body', 'status', 'published_at'];

    public function files()
    {
        return $this->hasMany(EmailFile::class, 'public_mail_id', 'id');
    }
}