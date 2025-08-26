<?php

namespace App\Imports;

use App\Models\CapaciteEtabConcours;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportCapacite implements ToModel, WithHeadingRow
{
    private $rows = 0;
    private $rowsIndex = 0;
    private $rowLost = "";
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $concours_id = request('concours_id');
        $session_id= request('session_id');
        $etablissement_id = trim($row['code']);
        $capacite = trim($row['capacite']);
        $code = trim($row['maj']);
        
        if($concours_id!='' && $session_id!="" && 
            $etablissement_id!="" && $capacite!="" && $code!=""){
                //dd($code);
            if($code==0){
                $capEtab = new CapaciteEtabConcours();
                $capEtab->session_id = $session_id;
                $capEtab->structure_id = $etablissement_id;
                $capEtab->concoursRattache_id = $concours_id;
                $capEtab->capacite = $capacite;
                $capEtab->restant = $capacite;
                $capEtab->update = true;
                $capEtab->save();
            }else{
                $capa = CapaciteEtabConcours::where(['session_id'=>$session_id,'structure_id'=>$etablissement_id,'concoursRattache_id'=>$concours_id])->get();
                if(count($capa)!=0){
                    $capEtab = $capa[0];
                    $capEtab->session_id = $session_id;
                    $capEtab->structure_id = $etablissement_id;
                    $capEtab->concoursRattache_id = $concours_id;
                    $capEtab->capacite = $capacite;
                    $capEtab->restant = $capacite;
                    $capEtab->update = true;
                    $capEtab->save();
                }else{
                    $capEtab = new CapaciteEtabConcours();
                    $capEtab->session_id = $session_id;
                    $capEtab->structure_id = $etablissement_id;
                    $capEtab->concoursRattache_id = $concours_id;
                    $capEtab->capacite = $capacite;
                    $capEtab->restant = $capacite;
                    $capEtab->update = true;
                    $capEtab->save();
                }
            }

            ++$this->rows;
            ++$this->rowsIndex;
        }else{
            if($this->rowLost!=""){
                $this->rowLost.=", ".$this->rowsIndex+2;
            }else{
                $this->rowLost=$this->rowsIndex+2;
            }
            
            ++$this->rowsIndex;
        }
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function getRowLost(): string
    {
        return $this->rowLost;
    }
}
