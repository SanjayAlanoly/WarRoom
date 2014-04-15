<?php
class FinanceFunctions extends BaseController
{


    public function createEvent()
    {

        DB::connection('cfrapp')->insert(" INSERT INTO events (event_name, image_url, ticket_price, description,
          date_range_from, date_range_to, venue_address, venue_address1, city_id, state_id, created_at, updated_at)
          VALUES('Finance Event', '', 10, 'To test finance app', '2013-10-21', '2013-10-22', 'Viveknagar', NULL,
          1, 1, NOW(), NOW())");
    }

}
