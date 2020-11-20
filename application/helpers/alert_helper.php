<?php

function alert($data,$tipe){
    if(isset($data) && isset($tipe)) {
        echo '<div class="alert alert-'.$tipe; echo' alert-dismissible fade show" role="alert">';
        echo $data;
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}

function agama($id = null){
    echo '<option value="islam"'; if(isset($id) && $id =='islam'){ echo 'selected';} echo '>Islam</option>';
    echo '<option value="yahudi"'; if(isset($id) && $id =='yahudi'){ echo 'selected';} echo '>Yahudi</option>';
    echo '<option value="protestan"'; if(isset($id) && $id =='protestan'){ echo 'selected';} echo '>Protestan</option>';
    echo '<option value="konghucu"'; if(isset($id) && $id == 'konghucu'){ echo 'selected';} echo '>Konghucu</option>';
    echo '<option value="kristen"'; if(isset($id) && $id =='kristen'){ echo 'selected';} echo '>Kristen</option>';
}

function ubah_date_time($timestamp){
    return date('Y-m-d H:i:s', strtotime($timestamp));
}