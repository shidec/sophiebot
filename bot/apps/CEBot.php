<?php
class CEBot extends Line_Apps{
			
	function on_follow(){
		$result = false;

		$db = new Database();
		if($this->option->get('current_event') == 'flash_sales'){
			$event_id = (int) $this->option->get('current_event_id');

			$r = $db->query("SELECT * FROM sales WHERE id = " . $event_id);
			$cek2 = $r->fetch_object();
			if($r->num_rows && $cek2->current_stock > 0 && $cek2->status == 1){
				$result = array();
				$result[] = array(
								'type' => 'text',
								'text' => $this->option->get('welcome_message')
							);

				$result[] = array(
								  "type" => "template",
								  "altText" => "Flash sale",
								  "template" => array(
								      "type" => "buttons",
								      "text" => $cek2->text . "\n\nStock : " . $cek2->current_stock,
								      "actions" => array(
								          array(
								            "type" => "message",
								            "label" => "Beli",
								            "text" => "/buy {$cek2->id}"
								          )
								      )
								  )
								);
			}
			$r->free();
		}else if($this->option->get('current_event') == 'auctions'){
			$event_id = (int) $this->option->get('current_event_id');

			$r = $db->query("SELECT * FROM auctions WHERE id = " . $event_id);
			$cek2 = $r->fetch_object();
			if($r->num_rows && $cek2->status == 1){

				$result = array();
				$result[] = array(
								'type' => 'text',
								'text' => $this->option->get('welcome_message')
							);

                $result[] = array("type" => "text",
                                    "text" => "{$cek2->caption}\nPenawaran : " . number_format($cek2->last_price, 0, ',', '.')
                                );

                $result[] = array("type" => "text",
                                    "text" => "Ikuti lelang dengan menulis /bid penawaran.\nmisal: /bid 5000"
                                );
            }
			$r->free();

		}else if($this->option->get('current_event') == 'polls'){
			$event_id = (int) $this->option->get('current_event_id');

			$r = $db->query("SELECT * FROM polls WHERE id = " . $event_id);
			$cek2 = $r->fetch_object();
			if($r->num_rows && $cek2->status == 1){
				$options = json_decode($cek2->options);
				$actions = array();
                foreach ($options as $k => $o) {
                    $actions[] = array(
                                        "type" => "message",
                                        "label" => $o,
                                        "text" => "/vote " . $k
                                      );
                }

				$result = array();
				$result[] = array(
								'type' => 'text',
								'text' => $this->option->get('welcome_message')
							);

                if(isset($cek2->image)){
                    $image = BASE_URL . 'uploads/polls/' . $cek2->image;
                    $result[] = array(
                                      "type" => "template",
                                      "altText" => "Poll",
                                      "template" => array(
                                          "type" => "buttons",
                                          "thumbnailImageUrl" => $image,
                                          "text" => $cek2->caption,
                                          "actions" => $actions
                                      )
                                    );
                }else{
                    $result[] = array(
                                      "type" => "template",
                                      "altText" => "Poll",
                                      "template" => array(
                                          "type" => "buttons",
                                          "text" => $cek2->caption,
                                          "actions" => $actions
                                      )
                                    );
                }
			}
			$r->free();
		}else if($this->option->get('current_event') == 'quizzes'){
			$event_id = (int) $this->option->get('current_event_id');

			$r = $db->query("SELECT * FROM quizzes WHERE id = " . $event_id);
			$cek2 = $r->fetch_object();
			if($r->num_rows && $cek2->status == 1){
				$options = json_decode($cek2->options);
				$actions = array();
                foreach ($options as $k => $o) {
                    $actions[] = array(
                                        "type" => "message",
                                        "label" => $o,
                                        "text" => "/answer " . chr(97 + $k)
                                      );
                }

				$result = array();
				$result[] = array(
								'type' => 'text',
								'text' => $this->option->get('welcome_message')
							);

                if(isset($cek2->image)){
                    $image = BASE_URL . 'uploads/quizzes/' . $cek2->image;
                    $result[] = array(
                                      "type" => "template",
                                      "altText" => "Quiz",
                                      "template" => array(
                                          "type" => "buttons",
                                          "thumbnailImageUrl" => $image,
                                          "text" => $cek2->caption,
                                          "actions" => $actions
                                      )
                                    );
                }else{
                    $result[] = array(
                                      "type" => "template",
                                      "altText" => "Quiz",
                                      "template" => array(
                                          "type" => "buttons",
                                          "text" => $cek2->caption,
                                          "actions" => $actions
                                      )
                                    );
                }
			}
			$r->free();
		}
		$db->close();

		if(!$result){
			$result = $this->option->get('welcome_message');
		}

		return $result;
	}
	
	function on_message($text){
		$result = '';
		if(substr($text, 0, 4) == '/buy'){
			$result = $this->processBuy($text);
		}else if(substr($text, 0, 4) == '/bid'){
			$result = $this->processBid($text);
		}else if(substr($text, 0, 5) == '/vote'){
			$result = $this->processVote($text);
		}else if(substr($text, 0, 7) == '/answer'){
			$result = $this->processAnswer($text);
		}

		return $result;
	}

	function processAnswer($text){
		$answer = trim(substr($text, 8)); 

		$current_event = $this->option->get('current_event');
		if($current_event != 'quizzes'){
			return 'Tidak ada event quiz saat ini';
		}

		$id = (int) $this->option->get('current_event_id');

		$db = new Database();
		$r = $db->query("SELECT id, status, score, answer FROM quizzes WHERE id  = {$id}");
		$cek = $r->fetch_object();

		if($cek){
			if($cek->status == 2){
				$result = 'Event quiz sudah berakhir';	
			}else{
				$r1 = $db->query("SELECT id FROM quiz_participants WHERE quiz_id  = {$id} AND customer_id = {$this->profile->id}");
				if($r1->num_rows){
					$result = 'Anda sudah mengikuti quiz ini';
				}else{
					$time = date('Y-m-d H:i:s');

					$score = $answer == $cek->answer ? $cek->score : 0;

					if($db->query("INSERT INTO quiz_participants (quiz_id, customer_id, answer, score, time) 
							VALUES ({$id}, {$this->profile->id}, '{$answer}', {$score}, '{$time}')")){
						$result = 'Terima kasih telah berpartisipasi dalam quiz ini';
					}else{
						$result = 'Terjadi kegagalan saat memproses jawaban Anda';
					}
				}
				$r1->free();
			}
		}else{
			$result = 'Event quiz tidak ada';
		}

		$r->free();
		$db->close();
		return $result;
	}

	function processVote($text){
		$vote = (int) trim(substr($text, 6)); 

		$current_event = $this->option->get('current_event');
		if($current_event != 'polls'){
			return 'Tidak ada event polling saat ini';
		}

		$id = (int) $this->option->get('current_event_id');

		$db = new Database();
		$r = $db->query("SELECT id, status FROM polls WHERE id  = {$id}");
		$cek = $r->fetch_object();

		if($cek){
			if($cek->status == 2){
				$result = 'Event lelang sudah berakhir';	
			}else{
				$r1 = $db->query("SELECT id FROM poll_participants WHERE poll_id  = {$id} AND customer_id = {$this->profile->id}");
				if($r1->num_rows){
					$result = 'Anda sudah mengikuti polling ini';
				}else{
					$time = date('Y-m-d H:i:s');

					if($db->query("INSERT INTO poll_participants (poll_id, customer_id, answer, time) 
							VALUES ({$id}, {$this->profile->id}, {$vote}, '{$time}')")){
						$result = 'Terima kasih telah berpartisipasi dalam polling ini';
					}else{
						$result = 'Terjadi kegagalan saat memproses pilihan Anda';
					}
				}
				$r1->free();
			}
		}else{
			$result = 'Event polling tidak ada';
		}

		$r->free();
		$db->close();
		return $result;
	}

	function processBid($text){
		$bid = (int) trim(substr($text, 4)); 

		$current_event = $this->option->get('current_event');
		if($current_event != 'auctions'){
			return 'Tidak ada event lelang saat ini';
		}

		$id = (int) $this->option->get('current_event_id');

		$db = new Database();
		$r = $db->query("SELECT id, last_price, last_customer, status FROM auctions WHERE id  = {$id}");
		$cek = $r->fetch_object();

		if($cek){
			if($cek->status == 2){
				$result = 'Event lelang sudah berakhir';	
			}else if($cek->last_price >= $bid){
				$result = 'Tawaran harus lebih besar dari harga terakhir ' . number_format($cek->last_price, 0, ',', '.');
			}else if($cek->last_customer == $this->profile->id){
				$result = 'Anda sudah melakukan penawaran terakhir';
			}else{
				$time = date('Y-m-d H:i:s');

				if($db->query("INSERT INTO auction_bids (auction_id, customer_id, price, time) 
						VALUES ({$id}, {$this->profile->id}, {$bid}, '{$time}')")){

					$sql = "UPDATE auctions SET 
						last_price = {$bid}, last_customer = {$this->profile->id}, last_time = '{$time}' WHERE id = {$id}";

					$db->query($sql);


					$r1 = $db->query("SELECT a.user_id FROM customers a 
						INNER JOIN auction_bids b ON a.id = b.customer_id AND b.auction_id = {$id}");
					$users = array();
					while ($d1 = $r1->fetch_object()) {
						$users[] = $d1->user_id;
					}

					$messages = array();
					$messages[] = array(
									'type' => 'text',
									'text' => 'Anda berhasil melakukan penawaran.');

					$messages[] = array(
									'type' => 'text',
									'text' => 'Penawaran saat ini ' . number_format($bid, 0, ',', '.'));

					$message = array('to' => $users, 'messages' => $messages);
					$this->client->multicast($message);

					$result = false;

					$r1->free();
				}else{
					$result = 'Terjadi kegagalan saat memproses penawaran Anda';
				}
			}
		}else{
			$result = 'Event lelang tidak ada';
		}

		$r->free();
		$db->close();
		return $result;
	}

	function processBuy($text){
		$current_event = $this->option->get('current_event');
		if($current_event != 'flash_sales'){
			return 'Tidak ada event flash sale saat ini';
		}

		$id = (int) $this->option->get('current_event_id');

		$db = new Database();
		$r = $db->query('SELECT id, stock, current_stock, status FROM sales WHERE id  = {$id}');
		$cek = $r->fetch_object();

		if($cek){
			if($cek->status == 2){
				$result = 'Event flash sales sudah berakhir';	
			}else if($cek->current_stock <= 0){
				$result = 'Persedian sudah habis';	
			}else{
				$r1 = $db->query('SELECT id FROM sale_buyers WHERE sale_id = ' . $id);
				if($r1->num_rows){
					$result = 'Anda sudah melakukan pembelian pada event ini. Tunggulah Customer service kami akan segera menghubungi Anda';
				}else{
					if($db->query('INSERT INTO sale_buyers (sale_id, customer_id) VALUES (' . ((int) $id) . ', '. ((int) $this->profile->id) . ')')){
						$r2 = $db->query("SELECT count(id) AS total FROM sale_buyers WHERE sale_id = {$id}");
						$cek2 = $r2->fetch_object();

						
						if($cek->stock > $cek2->total){
							$db->query("UPDATE sales SET current_stock = stock - {$cek2->total} WHERE id = {$id}");
						}else{
							$db->query("UPDATE sales SET current_stock = 0, status = 2, ended = CURRENT_TIMESTAMP WHERE id = {$id}");
							$this->option->set('current_event', '');
							$this->option->set('current_event_id', '');
						}
						$result = 'Anda berhasil melakukan pembelian. Customer service kami akan segera menghubungi Anda';	
					}else{
						$result = 'Terjadi kegagalan saat memproses pembelian Anda';
					}
					
				}
				$r1->free();
			}
		}else{
			$result = 'Event flash sales tidak ada';
		}

		$r->free();
		$db->close();
		return $result;
	}

}