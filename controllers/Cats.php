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
                $catsResult["status"] = 200;
                $row = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                foreach ($row as  $cat){
                    $p  = [
                        "id" => $cat['id'],
                        "name" => $cat['name'],
                        "colors" => $cat['colors']
                    ];

                    array_push($catsResult["body"], $p);
                }

                return $catsResult;
            } else {
                $response = [
                    'status_code' => 404,
                    'body' => 'nenhum gatinho encontrado :('
                ];

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
                    'status' => 200
                ];

                return $result;
            } else {
                $result  = [
                    'body' =>   'nenhum gatinho encontrado :(',
                    'status' => 404
                ];
                return $result;
            }
        }

        public function insertCat($data)
        {
            if ($data[0]['name']  && $data[0]['colors']) {
                $data[0]['colors'] = implode(', ', $data[0]['colors']);
                $keys = array_keys($data[0]);
                $stmt = $this->PDO->prepare("INSERT INTO Cats (" . implode(',', $keys) . ") VALUES (:" . implode(",:", $keys) . ")");
                $stmt->bindValue(':name', $data[0]['name']);
                $stmt->bindValue(':colors', $data[0]['colors']);
                $stmt->execute();
                $lastId = $this->PDO->lastInsertId();
                $data[0]['id'] = $lastId;

                if ($lastId > 0) {
                    $result = [
                        'body' => $data,
                        'status' => 201
                    ];

                    return $result;
                }

                $response = [
                    'body' => 'Ocorreu uma falha na plataforma. Por favor, entre em contato com o atendimento.',
                    'stats' => 500
                ];

                return $response;
            }

            $response  = [
                'body' => 'Não foi possível interpretar a requisição. Verifique a sintaxe das informações enviadas.',
                'status' => 400
            ];

            return $response;
        }

        public function updateCat($data,$id){

            if ($data[0]['name']  || $data[0]['colors']) {

                $data[0]['colors'] = implode(', ', $data[0]['colors']);
                
                if (count($data) > 0) {
                    foreach ($data[0] as $key => $value) {
                        $value = "'$value'";
                        $updates[] = "$key = $value";
                    }
                }

                $stmt = $this->PDO->prepare("UPDATE Cats SET ". $implodeArray = implode(', ', $updates)." WHERE id = :id");
                $stmt->bindValue(':id', $id);
                $stmt->execute();

                $query = "SELECT * FROM Cats WHERE id = :id";
                $stmt = $this->PDO->prepare($query);
                $stmt ->bindValue(':id',$id);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $response = [
                        'body' => $stmt->fetch(\PDO::FETCH_ASSOC),
                        'status' => 201
                    ];

                    return $response;
                } else {
                    $response = [
                        'body' => $implodeArray,
                        'status' => 500
                    ];
                    return $response;
                }
            }

            $response  = [
                'body' => 'Não foi possível interpretar a requisição. Verifique a sintaxe das informações enviadas.',
                'status' => 400
            ];

            return $response;

        }

        public function deleteCat($id){
            $stmt = $this->PDO->prepare("DELETE FROM Cats WHERE id = :id");
            $stmt ->bindValue(':id',$id);
            $stmt->execute();


            if ($stmt->rowCount() > 0) {
                $response = [
                    'status' => 200
                ];

                return $response;
            } else {
                $response = [
                    'body' => 'Ocorreu uma falha na plataforma. Por favor, entre em contato com o atendimento.',
                    'status' => 500
                ];
                return $response;
            }

        }
    }
}