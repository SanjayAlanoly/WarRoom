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

        $row = DB::connection('cfrapp')->select('SELECT id FROM events WHERE id = ? LIMIT 1',array($data->event_id));

        $city = DB::connection('cfrapp')->select('SELECT id,state_id FROM cities WHERE name = ?',array($data->event_city));

        if (empty($city[0])) {
            $city[0] = new stdClass();
            $city[0]->id = 25;
            $city[0]->state_id = 7;
        }

        if (empty($row[0])) {

            DB::connection('cfrapp')->insert("INSERT INTO events (id, event_name, image_url, ticket_price, description,
              date_range_from, date_range_to, venue_address, venue_address1, city_id, state_id, created_at, updated_at)
              VALUES(?, ?,  '', ?, ?, ?, ?, ?, NULL, ?, ?, NOW(), NOW())",
              array((int)$data->event_id, $data->event_name, $data->ticket_price, $data->event_descp,
              $data->event_start_date, $data->event_end_date, $data->venue_address, $city[0]->id, $city[0]->state_id));

        } else {
            DB::connection('cfrapp')->update('UPDATE events SET event_name = ?, ticket_price = ?, description = ?,
              date_range_from = ?, date_range_to = ?, venue_address = ?, city_id = ?, state_id = ?,updated_at = NOW()
              WHERE id =?',
              array($data->event_name, $data->ticket_price, $data->event_descp, $data->event_start_date,
              $data->event_end_date, $data->venue_address, $city[0]->id, $city[0]->state_id, $row[0]->id));
        }


    }

}
