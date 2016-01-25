<?php

    class Grid {

          public function build($datasource, $headers, $fields) {

                 $out = '<table border="1">';

                 $out .= $this->_make_header($headers);
             
                 foreach($datasource as $source) {

                         $className = get_class($source);

                         if($className != NULL) {
 
                            $reflector = new ReflectionClass($className);

                            $out .= $this->_make_row($reflector, $fields, $source);

                         }
                 }

                 $out .= '</table>';

              return $out;     
          }

          private function _make_header( $headers ) {

              $header = '<tr>';

              foreach($headers as $h) {
 
                     $header .= "<td>$h</td>";
              }

              $header .= '</tr>'; 

            return $header;
          }

          private function _make_row( $reflector, $fields, $source ) {

              $result = '<tr>';

              foreach($fields as $field):

                   if($reflector->hasProperty($field)):

                      $property = $reflector->getProperty($field);
                      $value = $property->getValue($source); 
                      $result .= "<td>$value</td>";

                   endif;

              endforeach;

              $result .= '</tr>';

             return $result; 
          }
    }

    class A {
          public $name = "Yii";
          public $desc = "Is a high-performance PHP Framework best for developing Web 2.0 applications.";
    }

    class B {
          public $name = "Codeigniter";
          public $desc = "Is a powerful PHP Framework with a very small footprint, built for PHP coders who need a simple and elegant toolkit to create full-featured web application.";
    }

    class C {
          public $name = "Kohana";
          public $desc = "An elegant HMVC PHP5 framework that provides a rich set of components for building web applications.";
    }

    $a = new A; 
    $b = new B;
    $c = new C;

    $headers = array("Name","Description");
    $fields = array("name","desc");

    $dataSource = array($a, $b, $c);

    $grid = new Grid;
    $table = $grid->build($dataSource, $headers, $fields);

    echo"<h1>Simple table generation using Reflection</h1>";
    echo"<h2>Top 10 Hot PHP Frameworks</h2>";

    echo$table;
?>