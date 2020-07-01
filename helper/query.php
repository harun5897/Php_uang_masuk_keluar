<?php

class Query extends Koneksi{
   

   public function getSaldo () {
      $data = mysqli_query($koneksi, "SELECT * FROM tb_saldo WHERE id = 1");
      $arr = mysqli_fetch_array($data);
   
      // return $arr['saldo'];
   
      return $koneksi;
   }
   
  public  function update_saldo($tipe, $temp) {
   
      $saldo = getSaldo();
      if($tipe == 'masuk')
      {
          $saldo = $saldo + $temp;
      }
      else {
          $saldo = $saldo - $temp;
      }
     $simpan =  mysqli_query($koneksi, "UPDATE tb_saldo SET 
                  saldo = ".$saldo."
   
                  WHERE id = 1
               ");    
               
               print_r($simpan);
   
      return $saldo;
   }
   
  public function addData ($table, $field, $values) {
      $value = '';
      foreach ($values as $value) {
         $value = $value + ', ';
      }
      
      $simpan = mysqli_query($koneksi, "INSERT INTO ".$table." ". $field."  
      VALUES ('$value')
      ");
   
      return $simpan;
   }
}

