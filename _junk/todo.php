

    USER                   MIDDLEWARE    YOUR WEB APP       MIDDLEWARE

    submitting request        ->          produces json     *->                USER

    ---------------------------------------------------------------------------------

    submitting request        **->          produces json






**  Make sure either is EITHER admin or that member_id MATCHES member_id

    THEN....

    If ($user_level != 'admin') {
            $allowed_update_cols[] = 'username';
            $allowed_update_cols[] = 'phone_number';
            $allowed_update_cols[] = 'email';

            //$submitted_params
            foreach($submitted_params as $key=>$column_name) {

                if (!in_array($column_name, $allowed_update_col)) {
                        echo 'not allowed'; die();
                }


            }

    }







* if user_level is not admin then do NOT return date_of_birth

if ($user_level != 'admin') {
    unset($data['date_of_birth']);
    unset($data['password']);
}









* Make sure the table exists (safely!)

* add the actual URL to the URL Segments section

* Clean up code (for example, remove the 'order by' checks that are not being used)
        
* Get before and after hooks working

* Get custom endpoints working WITH HOOKS

_______________________________________________________________


NEXT DAY

* Finish all of the endpoints

---------------------------------------------------------------

AND FINALLY

* bolster all of the security


















TUESDAY GOALS


* Change structure so that API is a part of the engine.                                     DONE

* Change location of settings file.
    -> every module gets an 'assets' folder.  The settings file should be called api.json.  DONE

* Add feature to top right hand side for adding token to header.                            DONE

* Get 'bypass authorization' working.                                                       DONE

* Get one API endpoint working completely.                                                  DONE

                                            YES YES YES!!!


---------------------------------------------------------------

WEDNESDAY GOALS

* get params working, including limit, offset and order by
   (as well as WHERE conditions)

* make the 'bypass' auth feature secure : USE THE FANCY VIBE

* get the security working. Have the following options:

            






















* make 'token' a required field for the GET request.

* leave params empty

* get it working.

* update the segments

* get the result and display it on the server

* allow user to pass variables across

* allow user to bypass authentication


ONE WORKS !!!!  THIS IS GOOD !!!!


---------------------------------------------------------------



* get dates working (all variations)

* only display btm pagination if num on page >=10  ?

* Get search working.

* Get per page working.

* Make sure it looks good on mobile devices and other browsers.

* Beautify the code.

* get delete item working.

* INTEGRATE WITH CODE GENERATOR ~ TOTALLY GET IT WORKING

---------------------------------------------------------------





































---------------------------------------------------------------



* Get comments working (without refreshing page)

* Get update details working.

* Get display details working.

* Get search working.

* Get per page working.

* Get ALL of the different form fields working properly.

* Make sure it looks good on mobile devices and other browsers.

* Beautify the code.

* INTEGRATE WITH CODE GENERATOR ~ TOTALLY GET IT WORKING

---------------------------------------------------------------

* GET PICTURE UPLOADER WORKING (both kinds)

---------------------------------------------------------------

* GET MODULE RELATIONS WORKING

---------------------------------------------------------------

* WRAP UP THE CODE GENERATOR AND LAUNCH :  this will be v1