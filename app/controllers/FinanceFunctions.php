<?php
class FinanceFunctions extends BaseController
{


    public function createEvent()
    {

        $request = Request::instance();

        $content = $request->getContent();

        $data = json_decode($content);

        $row = DB::connection('cfrapp')->select('SELECT TOP 1 FROM events WHERE id = ?',array($data->event_id));

        $city = DB::connection('cfrapp')->select('SELECT id,state_id FROM cities WHERE name = ?',array($data->event_city));

        if (empty($city)) {
            $city->id = 25;
            $city->state_id = 7;
        }

        if (empty($row)) {

            DB::connection('cfrapp')->insert("INSERT INTO events (id, event_name, image_url, ticket_price, description,
              date_range_from, date_range_to, venue_address, venue_address1, city_id, state_id, created_at, updated_at)
              VALUES(?, ?,  '', ?, ?, ?, ?, ?, NULL, ?, ?, NOW(), NOW())",
              array((int)$data->event_id, $data->event_name, $data->ticket_price, $data->event_descp,
              $data->event_start_date, $data->event_end_date, $data->venue_address, $city->id, $city->state_id));

        } else {
            DB::connection('cfrapp')->update('UPDATE events SET event_name = ?, ticket_price = ?, description = ?,
              date_range_from = ?, date_range_to = ?, venue_address = ?, city_id = ?, state_id = ?,updated_at = NOW()',
              array($data->event_name, $data->ticket_price, $data->event_descp, $data->event_start_date,
              $data->event_end_date, $data->venue_address, $city->id, $city->state_id));
        }


    }

}
