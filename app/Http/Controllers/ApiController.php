<?php

namespace App\Http\Controllers;

use App\Http\Helpers\InfusionsoftHelper;
use App\Http\Services\RightTagFinder;
use App\Http\Requests\ApiRequest;
use Illuminate\Http\JsonResponse;
use Response;
use App\User;
use App\Module;
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{
    public function reminder(ApiRequest $request) :JsonResponse {
        $infusionsoft = new InfusionsoftHelper();

        $contact = $infusionsoft->getContact($request->get('email'));
        $user = User::where('email', $contact['Email'])->first();
        $tagId = RightTagFinder::getNextCourseFor($user, $contact, $this->fetchAllTags($infusionsoft));

        return Response::json([
            'status' => $infusionsoft->addTag($contact['Id'], $tagId)
        ]);
    }

    private function fetchAllTags($infusionsoft){
        return Cache::rememberForever('all-tags', function () use ($infusionsoft) {
            return $infusionsoft->getAllTags();
        });
    }


    // Todo: Module reminder assigner

    public static function exampleCustomer(){

        $infusionsoft = new InfusionsoftHelper();

        $uniqid = uniqid();

        $infusionsoft->createContact([
            'Email' => $uniqid.'@test.com',
            "_Products" => 'ipa,iea'
        ]);

        $user = User::create([
            'name' => 'Test ' . $uniqid,
            'email' => $uniqid.'@test.com',
            'password' => bcrypt($uniqid)
        ]);

        // attach IPA M1-3 & M5
        $user->completed_modules()->attach(Module::where('course_key', 'ipa')->limit(3)->get());
        $user->completed_modules()->attach(Module::where('name', 'IPA Module 5')->first());


        return $user;
    }
}
