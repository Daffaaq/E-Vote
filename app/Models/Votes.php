<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votes extends Model
{
    use HasFactory;

    protected $table = 'votes';

    protected $fillable = [
        'periode_id',
        'students_id',
        'candidate_id',
        'jadwal_votes_id',
        'status_vote',
        'jam_vote',
    ];

    /**
     * Get the periode associated with the vote.
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    /**
     * Get the student associated with the vote.
     */
    public function student()
    {
        return $this->belongsTo(Students::class);
    }

    /**
     * Get the candidate associated with the vote.
     */
    public function candidate()
    {
        return $this->belongsTo(Candidates::class);
    }

    /**
     * Get the jadwal_votes associated with the vote.
     */
    public function jadwalVote()
    {
        return $this->belongsTo(JadwalVotes::class);
    }
}
