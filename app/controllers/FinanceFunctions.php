<?php

class FinanceFunctions extends BaseController
{

    function getClient()
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        require_once(app_path().'/includes/soapclient/SforcePartnerClient.php');
        require_once(app_path().'/includes/soapclient/SforceHeaderOptions.php');

        // Salesforce Login information
        $wsdl = app_path().'/includes/soapclient/partner.wsdl.xml';
        $userName = "binnyva@makeadiff.in";
        $password = "tracker101"."2pCRukHlm47CKXCmUWpDuLIKv";

        // Process of logging on and getting a salesforce.com session
        $client = new SforcePartnerClient();
        $client->createConnection($wsdl);
        $loginResult = $client->login($userName, $password);

        return $client;
    }

    function updateSalesforceCFRDonation()
    {
        $client = $this->getClient();

        $query = "SELECT Id,City__c FROM CFR__c";
        $result = $client->query($query);

        $i = 0;

        foreach ($result as $record) {
            $cfr[$i] = new SObject();
            $cfr[$i]->Id = $record->Id;
            $total_donation = $this->getTotalDonation($record->City__c);
            $with_volunteer = $this->getCFRAmountWithVolunteer($record->City__c);
            $with_poc = $this->getCFRAmountWithPOC($record->City__c);
            $with_fc = $this->getCFRAmountWithFC($record->City__c);
            $deposit_complete = $this->getCFRAmountDepositComplete($record->City__c);

            echo "City : " . $record->City__c . " Total Donation : " . $total_donation . "<br>";
            echo "With Volunteer : $with_volunteer With POC : $with_poc With FC : $with_fc  Deposit Complete : $deposit_complete <br><br>";

            $cfr[$i]->fields = array(
                'Total_Donation__c' => $total_donation,
                'With_Volunteer__c' => $with_volunteer,
                'With_POC__c' => $with_poc,
                'With_FC__c' => $with_fc,
                'Deposit_Complete__c' => $deposit_complete,
            );
            $cfr[$i]->type = 'CFR__c';
            $i++;
        }

        $client->update($cfr);



    }

    function getTotalDonation($city)
    {
        $total_donation = DB::connection('cfrapp')->select('SELECT COALESCE(SUM(donation_amount),0) as sum FROM donations
                                                            INNER JOIN users
                                                            ON donations.fundraiser_id = users.id
                                                            INNER JOIN cities
                                                            ON users.city_id = cities.id
                                                            WHERE cities.name = ?',array($city));
        if (!empty($total_donation[0]->sum)) {
            return $total_donation[0]->sum;

        }else{
            return 0;
        }

    }

    function getCFRAmountWithVolunteer($city)
    {
        $with_volunteer = DB::connection('cfrapp')->select('SELECT COALESCE(SUM(donation_amount),0) AS sum FROM donations
                                                            INNER JOIN users
                                                            ON donations.fundraiser_id = users.id
                                                            INNER JOIN cities
                                                            ON users.city_id = cities.id
                                                            WHERE cities.name = ?
                                                            AND donations.donation_status = ?',array($city,'TO_BE_APPROVED_BY_POC'));


        if (!empty($with_volunteer[0]->sum)) {
            return $with_volunteer[0]->sum;

        }else{
            return 0;
        }

    }

    function getCFRAmountWithPOC($city)
    {
        $with_poc = DB::connection('cfrapp')->select('SELECT COALESCE(SUM(donation_amount),0) AS sum FROM donations
                                                            INNER JOIN users
                                                            ON donations.fundraiser_id = users.id
                                                            INNER JOIN cities
                                                            ON users.city_id = cities.id
                                                            WHERE cities.name = ?
                                                            AND donations.donation_status = ?',array($city,'HAND_OVER_TO_FC_PENDING'));

        if (!empty($with_poc[0]->sum)) {
            return $with_poc[0]->sum;

        }else{
            return 0;
        }

    }

    function getCFRAmountWithFC($city)
    {
        $with_fc = DB::connection('cfrapp')->select('SELECT COALESCE(SUM(donation_amount),0) AS sum FROM donations
                                                            INNER JOIN users
                                                            ON donations.fundraiser_id = users.id
                                                            INNER JOIN cities
                                                            ON users.city_id = cities.id
                                                            WHERE cities.name = ?
                                                            AND donations.donation_status = ?',array($city,'DEPOSIT_PENDING'));

        if (!empty($with_fc[0]->sum)) {
            return $with_fc[0]->sum;

        }else{
            return 0;
        }

    }


    function getCFRAmountDepositComplete($city)
    {
        $deposit_complete = DB::connection('cfrapp')->select('SELECT COALESCE(SUM(donation_amount),0) AS sum FROM donations
                                                            INNER JOIN users
                                                            ON donations.fundraiser_id = users.id
                                                            INNER JOIN cities
                                                            ON users.city_id = cities.id
                                                            WHERE cities.name = ?
                                                            AND (donations.donation_status = ? OR donations.donation_status = ? OR donations.donation_status = ?)
                                                            ',array($city,'DEPOSIT COMPLETE','RECEIPT PENDING','RECEIPT SENT'));

        if (!empty($deposit_complete[0]->sum)) {
            return $deposit_complete[0]->sum;

        }else{
            return 0;
        }

    }

    function updateSalesforceEventTicketSale()
    {
        $client = $this->getClient();

        $query = "SELECT Id,Name FROM Event__c";
        $result = $client->query($query);

        $i = 0;

        foreach ($result as $record) {
            $events[$i] = new SObject();
            $events[$i]->Id = $record->Id;
            $ticket_sale = $this->getTicketSale($record->Name);
            $with_intern = $this->getEventAmountWithIntern($record->Name);
            $with_event_head = $this->getEventAmountWithEventHead($record->Name);
            $with_FC = $this->getEventAmountWithFC($record->Name);
            $deposit_complete = $this->getEventAmountDepositComplete($record->Name);

            echo "Event : " . $record->Name . " Ticket Sale : " . $ticket_sale . "<br>";
            echo "With Intern : $with_intern With Events Head : $with_event_head With FC : $with_FC  Deposit Complete : $deposit_complete <br><br>";

            $events[$i]->fields = array(
                'Total_Ticket_Sale__c' => $ticket_sale,
                'With_Intern__c' => $with_intern,
                'With_Event_Head__c' => $with_event_head,
                'With_FC__c' => $with_FC,
                'Deposit_Complete__c' => $deposit_complete,
            );
            $events[$i]->type = 'Event__c';
            $i++;
        }

        $client->update($events);



    }

    function getTicketSale($id)
    {
        $ticket_sale = DB::connection('cfrapp')->select('SELECT COALESCE(SUM(donation_amount),0) as sum FROM event_donations
                                                            WHERE event_id = ?',array($id));
        if (!empty($ticket_sale[0]->sum)) {
           return $ticket_sale[0]->sum;

        }else{
            return 0;
        }

    }

    function getEventAmountWithIntern($id)
    {
        $with_intern = DB::connection('cfrapp')->select('SELECT COALESCE(SUM(donation_amount),0) AS sum from event_donations
                                                            WHERE event_id = ? AND donation_status = ?',
                                                            array($id,'TO_BE_APPROVED_BY_EVENT_HEAD'));

        if (!empty($with_intern[0]->sum)) {
            return $with_intern[0]->sum;

        }else{
            return 0;
        }

    }

    function getEventAmountWithEventHead($id)
    {
        $with_event_head = DB::connection('cfrapp')->select('SELECT COALESCE(SUM(donation_amount),0) AS sum from event_donations
                                                            WHERE event_id = ? AND donation_status = ?',
                                                            array($id,'EVENT_DONATION_HAND_OVER_TO_FC_PENDING'));

        if (!empty($with_event_head[0]->sum)) {
            return $with_event_head[0]->sum;

        }else{
            return 0;
        }

    }

    function getEventAmountWithFC($id)
    {
        $with_FC = DB::connection('cfrapp')->select('SELECT COALESCE(SUM(donation_amount),0) AS sum from event_donations
                                                            WHERE event_id = ? AND donation_status = ?',
                                                            array($id,'EVENT_DONATION_DEPOSIT_PENDING'));

        if (!empty($with_FC[0]->sum)) {
            return $with_FC[0]->sum;

        }else{
            return 0;
        }

    }


    function getEventAmountDepositComplete($id)
    {
        $deposit_complete = DB::connection('cfrapp')->select('SELECT COALESCE(SUM(donation_amount),0) AS sum from event_donations
                                                            WHERE event_id = ? AND donation_status = ?',
                                                            array($id,'EVENT_DONATION_DEPOSIT_COMPLETE'));

        if (!empty($deposit_complete[0]->sum)) {
            return $deposit_complete[0]->sum;

        }else{
            return 0;
        }

    }


    public function createEvent()
    {

        $request = Request::instance();

        $content = $request->getContent();

        $data = json_decode($content);

        if ( empty($data->event_id) ) {

            $data = new stdClass();

            $data->event_id = 800;
            $data->event_name = 'Tirgger Test Event';
            $data->event_city = 'Bangalore';
            $data->event_descp = "Test Event";
            $data->event_start_date = '';
            $data->event_end_date = '';
            $data->venue_address = '';
            $data->ticket_a_type = 'Gold';
            $data->ticket_a_price = 100;
            $data->ticket_b_type = 'Silver';
            $data->ticket_b_price = 50;
            $data->ticket_c_type = 'Bronze';
            $data->ticket_c_price = 10;
            /*$data->ticket_d_type = '';
            $data->ticket_d_price = 0;
            $data->ticket_e_type = '';
            $data->ticket_e_price = 0;*/

        }

        DB::connection('cfrapp')->insert("INSERT INTO event_ticket_types (name,ticket_price,event_id,keyword) VALUES (?,?,?,?)",
            array('silver',100,800,'silver'));

        $row = DB::connection('cfrapp')->select('SELECT id FROM events WHERE id = ? LIMIT 1',array((int)$data->event_id));

        $city = DB::connection('cfrapp')->select('SELECT id,state_id FROM cities WHERE name = ?',array($data->event_city));

        if (empty($city[0])) {
            $city[0] = new stdClass();
            $city[0]->id = 25;
            $city[0]->state_id = 7;
        }

        DB::connection('cfrapp')->insert("INSERT INTO event_ticket_types (name,ticket_price,event_id,keyword) VALUES (?,?,?,?)",
            array('gold',200,800,'gold'));

        if (empty($row[0])) {

            DB::connection('cfrapp')->insert("INSERT INTO events (id, event_name, image_url, description,
              date_range_from, date_range_to, venue_address, venue_address1, city_id, state_id, created_at, updated_at)
              VALUES(?, ?,  '', ?, ?, ?, ?, NULL, ?, ?, NOW(), NOW())",
              array((int)$data->event_id, $data->event_name, $data->event_descp,
              $data->event_start_date, $data->event_end_date, $data->venue_address, $city[0]->id, $city[0]->state_id));

            $letters = range('a','e');

            foreach($letters as $letter){

                $ticket = "ticket_";
                $type = "_type";
                $price = "_price";

                if ( !empty($data->{$ticket.$letter.$type}) ) {

                    $keyword = preg_replace("/\s+/", " ", $data->{$ticket.$letter.$type});
                    $keyword = str_replace(" ", "_", $keyword);
                    $keyword = preg_replace("/[^A-Za-z0-9_]/","",$keyword);
                    $keyword=strtolower($keyword);


                    DB::connection('cfrapp')->insert("INSERT INTO event_ticket_types (name,ticket_price,event_id,keyword) VALUES (?,?,?,?)",
                        array($data->{$ticket.$letter.$type},$data->{$ticket.$letter.$price},(int)$data->event_id,$keyword));
                }

            }



        } else {
            DB::connection('cfrapp')->update('UPDATE events SET event_name = ?, description = ?,
              date_range_from = ?, date_range_to = ?, venue_address = ?, city_id = ?, state_id = ?,updated_at = NOW()
              WHERE id =?',
              array($data->event_name,$data->event_descp, $data->event_start_date,
              $data->event_end_date, $data->venue_address, $city[0]->id, $city[0]->state_id, $row[0]->id));

            DB::connection('cfrapp')->delete('DELETE FROM event_ticket_types WHERE event_id = ?',array((int)$data->event_id));

            $letters = range('a','e');

            foreach($letters as $letter){

                $ticket = "ticket_";
                $type = "_type";
                $price = "_price";

                if( !empty($data->{$ticket.$letter.$type}) ){

                    $keyword = preg_replace("/\s+/", " ", $data->{$ticket.$letter.$type});
                    $keyword = str_replace(" ", "_", $keyword);
                    $keyword = preg_replace("/[^A-Za-z0-9_]/","",$keyword);
                    $keyword=strtolower($keyword);


                    DB::connection('cfrapp')->insert("INSERT INTO event_ticket_types (name,ticket_price,event_id,keyword) VALUES (?,?,?,?)",
                        array($data->{$ticket.$letter.$type},$data->{$ticket.$letter.$price},(int)$data->event_id,$keyword));
                }

            }
        }


    }

}
