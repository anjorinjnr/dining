<?php

namespace Neartutor\Models;

/**
 * Description of Subject
 *
 * @author kayfun
 */
class Subject extends \Eloquent {

    protected $guarded = array();
    protected $hidden = array('updated_at', 'created_at', 'pivot');

    public function categories() {
        return $this->belongsToMany('Neartutor\Models\Category', 'subject_categories', 'subject_id', 'category_id')->select(array('id'));
    }

    public function getId() {
        return $this->id;
    }

    public function getSubjectName() {
        return $this->title;
    }

    //filter for approved subjects
    public function scopeApproved($query) {
        return $query->where('approved', '=', 1);
    }

    public function getRate() {
        return $this->rate;
    }

    public function isVerified() {
        return $this->verified;
    }

}
