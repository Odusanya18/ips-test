<?php

namespace App\Http\Services;

class RightTagFinder 
{
    public static function getNextCourseFor($user, $contact, $tags) {
        $purchases = explode(',', $contact['_Products']);
        $completes = $user->completed_modules()->get();

        // possible courses are purchases in tags
        $possibleCourses = self::getPossibleCoursesFrom($purchases, $tags);
        $nextCourses = self::getNextCoursesFrom($possibleCourses, $completes);

        return next($nextCourses)->id;
    }

    private static function getNextCoursesFrom($possibleCourses, $completes){
        return array_filter($possibleCourses, function($tag) use ($completes){
            foreach ($completes as $completed) {
                if (stripos($tag->name, $completed->name)) {
                    return false;
                }
            }

            return true;
        });
    }

    private static function getPossibleCoursesFrom($purchases, $tags){
        $possibleCourses = [];
        foreach ($purchases as $purchase) {
            $count = count($tags);
            for ($i = 0; $i < $count; $i++) { 
                if (stripos($tags[$i]->name, $purchase)) {
                    $possibleCourses[] = $tags[$i];
                }
            }
        }

        return $possibleCourses;
    }
}
