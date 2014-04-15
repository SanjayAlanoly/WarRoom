<?php
class FinanceFunctions extends BaseController
{


    public function createEvent()
    {

        $request = Request::instance();

        $content = $request->getContent();

        $data = json_decode($content);

        DB::connection('cfrapp')->insert(" INSERT INTO events (event_name, image_url, ticket_price, description,
          date_range_from, date_range_to, venue_address, venue_address1, city_id, state_id, created_at, updated_at)
          VALUES(?, '',?, 'To test finance app', ?, ?, 'Viveknagar', NULL,
          1, 1, NOW(), NOW())",array($data->event_name,$data->ticket_price,$data->event_date,$data->event_date));
    }

}
