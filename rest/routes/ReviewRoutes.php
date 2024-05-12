<?php
//works
//get all information regarding all reviews
Flight::route('GET /reviews', function () {
    Flight::json(Flight::reviewService()->get_all());
});

//works
//add a new review
Flight::route('POST /reviews', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::reviewService()->add($data));
});

//works, and returns all results that satisfy the condition
//get all reviews with a certain review score
Flight::route('GET /reviews/reviewscores/@review_score', function ($review_score) {
    Flight::json(Flight::reviewService()->getCarsWithCertainScores($review_score));
});

//works
Flight::route('DELETE /reviews/@review_id', function ($review_id) {
    Flight::reviewService()->delete($review_id);
});

//works
Flight::route('GET /reviews/@review_id', function ($review_id) {
    Flight::json(Flight::reviewService()->get_by_id($review_id));
});

//works
Flight::route("PUT /reviews/@review_id", function($review_id){
    $data = Flight::request()->data->getData();
    Flight::json(['message' => 'Review edited succesfully', 'data' => Flight::reviewService()->update($data, $review_id)]); 
    //-> converts the results to the JSON form
    //This array we could have created above, store it in a variable, and then call that variable or do it directly like this
});


?>
