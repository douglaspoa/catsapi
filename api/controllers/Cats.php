<?php
namespace controllers{
    class Cats
    {
        private $PDO;

        function __construct()
        {
            $this->PDO = new \PDO('mysql:host=localhost;dbname=pmweb', 'root', 'root'); //Conexão
        }

        public function getAll()
        {
            $query = "SELECT * FROM Cats";

            $stmt = $this->PDO->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();

            if($count > 0){


                $catsResult = [];
                $catsResult["body"] = [];
                $catsResult["count"] = $count;
                $row = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                foreach ($row as  $cat){
                    $p  = [
                        "id" => $cat['id'],
                        "name" => $cat['name'],
                        "color" => $cat['color']
                    ];

                    array_push($catsResult["body"], $p);
                }

                return json_encode($catsResult);
            } else {
                $response = [
                    'status_code' => 404,
                    'message' => 'nenhum gatinho encontrado :('
                ];
                $response = json_encode($response);
                return $response;
            }
        }

        public function getCat($id)
        {
            $query = "SELECT * FROM Cats WHERE id = :id";
            $stmt = $this->PDO->prepare($query);
            $stmt ->bindValue(':id',$id);
            $stmt->execute();

            $count = $stmt->rowCount();
            if($count > 0) {
                $result =[
                    'body' => $stmt->fetch(\PDO::FETCH_ASSOC),
                    'status_code' => '200'
                ];

                return json_encode($result);
            } else {
                $result  = [
                    'message' =>   'nenhum gatinho encontrado :(',
                    'status_code' => '404'
                ];
                return json_encode($result);
            }
        }

        public function insertCat($data)
        {
            $keys = array_keys($data[0]);
            $stmt = $this->PDO->prepare("INSERT INTO Cats (".implode(',', $keys).") VALUES (:".implode(",:", $keys).")");
            $stmt ->bindValue(':name', $data[0]['name']);
            $stmt ->bindValue(':color', $data[0]['color']);
            $stmt->execute();
            $lastId = $this->PDO->lastInsertId();

            if ($lastId > 0) {
                $result =[
                    'body' => $data,
                    'status_code' => '201'
                ];

                return json_encode($result);
            }

            $response  = [
                'message' => 'Ocorreu uma falha na plataforma. Por favor, entre em contato com o atendimento.',
                'status_code' => '500'
            ];

            return json_encode($response);
        }

        public function updateCat($data,$id){

            if ($data[0]['name']  && $data[0]['color']) {


                $stmt = $this->PDO->prepare("UPDATE Cats SET name = :name, color = :color WHERE id = :id");
                $stmt->bindValue(':id', $id);
                $stmt->bindValue(':name', $data[0]['name']);
                $stmt->bindValue(':color', $data[0]['color']);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $response = [
                        'body' => $data,
                        'status_code' => '201'
                    ];

                    return json_encode($response);
                } else {
                    $response = [
                        'message' => 'Ocorreu uma falha na plataforma. Por favor, entre em contato com o atendimento.',
                        'status_code' => '500'
                    ];
                    return json_encode($response);
                }
            }

            $response  = [
                'message' => 'Não foi possível interpretar a requisição. Verifique a sintaxe das informações enviadas.',
                'status_code' => '400'
            ];

            return json_encode($response);

        }

        public function deleteCat($id){
            $stmt = $this->PDO->prepare("DELETE FROM Cats WHERE id = :id");
            $stmt ->bindValue(':id',$id);
            $stmt->execute();


            if ($stmt->rowCount() > 0) {
                $response = [
                    'status_code' => '200'
                ];

                return json_encode($response);
            } else {
                $response = [
                    'message' => 'Ocorreu uma falha na plataforma. Por favor, entre em contato com o atendimento.',
                    'status_code' => '500'
                ];
                return json_encode($response);
            }

        }
    }
}