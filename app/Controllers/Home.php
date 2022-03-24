<?php

namespace App\Controllers;

use PHPUnit\Util\Json;

// allows requests
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS, PUT, POST");

class Home extends BaseController
{
	public function index()
	{
		// initialise request & db
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		// gets contents of request
		$requestAll = JSON_decode(file_get_contents('php://input'), true);
		// gets request method (get, post etc)
		$method = $request->getMethod();
		// selects which table
		$builder = $db->table('events');

		// adding events
		if ($method === 'post') {
			$requestAll['event_start'] = date('Y-m-d H:i', strtotime($requestAll['event_start']));
			$requestAll['event_end'] = date('Y-m-d H:i', strtotime($requestAll['event_end']));
			// $newDate = date('Y-m-d H:i' ,strtotime($myIsoDate))

			$builder->insert($requestAll);
		}

		// retrieve events
		if ($method === "get") {
			$query = $builder->get();
			// gets data and returns it in  json
			$this->response->setContentType('application/json');
			$data = $query->getResult();
			return json_encode($data);
		}
	}
	public function deleteEvent()
	{
		// initialise request & db
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		// gets contents of request
		$requestAll = JSON_decode(file_get_contents('php://input'), true);
		$builder = $db->table('events');

		// combines data with db columns ready for insertion
		$fields = ['id'];
		$data = array_combine($fields, $requestAll);

		$builder->delete($data);
		// $this->response->setContentType('application/json');
		// echo JSON_encode($data);
	}
	public function updateEvent()
	{
		// initialise request & db
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		// gets contents of request
		$requestAll = JSON_decode(file_get_contents('php://input'), true);
		$builder = $db->table('events');

		// combines data with db columns ready for insertion
		$fields = ['id', 'event_name', 'event_desc', 'event_isAllDay', 'event_start', 'event_end'];
		$data = array_combine($fields, $requestAll);

		$data['event_start'] = date('Y-m-d H:i', strtotime($data['event_start']));
		$data['event_end'] = date('Y-m-d H:i', strtotime($data['event_end']));

		// replaces existing data with incoming data based on INDEX
		$builder->replace($data);
	}


	public function searchByHour()
	{
		// initialise request & db
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$this->response->setContentType('application/json');

		$builder = $db->table('events');
		$builder->select("HOUR(event_start) as hour, COUNT(HOUR(event_start)) as bookings");
		$builder->groupBy("HOUR(event_start)");
		$data = $builder->get()->getResultArray();
		// $output = $builder->getCompiledSelect();
		echo JSON_encode($data);
	}

	public function searchByDay()
	{
		// initialise request & db
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$this->response->setContentType('application/json');

	}
	public function searchByDate()
	{
		// initialise request & db
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$this->response->setContentType('application/json');

		$builder = $db->table('events');
		echo JSON_encode(["Date"]);
	}
	public function searchByWeek()
	{
		// initialise request & db
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$this->response->setContentType('application/json');

		$builder = $db->table('events');
		echo JSON_encode(["Week"]);
	}
	public function searchByMonth()
	{
		// initialise request & db
		$request = \Config\Services::request();
		$db = \Config\Database::connect();
		$this->response->setContentType('application/json');

		$builder = $db->table('events');
		$builder->select("MONTH(event_start) as month, COUNT(MONTH(event_start)) as bookings");
		$builder->groupBy("MONTH(event_start)");
		$data = $builder->get()->getResultArray();
		// $output = $builder->getCompiledSelect();
		echo JSON_encode($data);
	}
}
