<?php
class DeleteDonation extends BaseController {



    public function showDeleteDonation(){

        return View::make('DeleteDonation');
    }

    public function submitID(){

        $donation_id = $_POST['donation_id'];
        $ids = explode(",",$donation_id);
        $ids_string = "";

        foreach($ids as $id){
            DB::connection('cfrapp')->insert("INSERT INTO deleted_donations SELECT * FROM donations
                                                WHERE donations.id = ?",array($id));
            DB::connection('cfrapp')->delete("DELETE FROM donations WHERE id = ?",array($id));
            DB::connection('cfrapp')->insert("INSERT INTO deleted_donation_versions SELECT * FROM donation_versions
                                                WHERE donation_id = ?",array($id));
            DB::connection('cfrapp')->delete("DELETE FROM donation_versions WHERE donation_id = ?",array($id));

            $ids_string = $ids_string . " " . $id;


        }


        return Redirect::to('DeleteDonation')->with('message',"$ids_string deleted by " . Auth::user()->first_name);


    }

}