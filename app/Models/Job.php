<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Job extends Model {
    use HasFactory;

    protected $table = "job_listings";

    // Laravel security check to allow only specific columns to be mass-filled and not other columns (by mistake)
    // protected $fillable = ['title', 'salary'];

    // guarded columns means to be allowed...
    protected $guarded = [];    // empty array means 'allow all'

    public function employer() {
        return $this->belongsTo(Employer::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, foreignPivotKey:"job_listing_id");
    }

}

?>
