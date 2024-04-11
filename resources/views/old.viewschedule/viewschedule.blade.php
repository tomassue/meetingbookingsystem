@extends('layouts.app')

@section('content')

<div class="card mt-5 ">
   
    <div class="row mt-3 col-md-12 p-3">
        <div class="col">
        <div class="input-group mb-3">
            <span class="input-group-text" >Department</span>
            <select class="form-select" >
                <option></option>
                
              </select>
            
        </div>
        </div>

        <div class="col">
        <div class="input-group mb-3">
            <span class="input-group-text" >Search</span>
            <input type="text" class="form-control">
            
        </div>
        </div>

       
    </div>

    <div class="row col-md-6 p-3">
        <div class="col">
        <div class="input-group mb-3">
            <span class="input-group-text" >From</span>
            <input type="date" class="form-control">
            
        </div>
        </div>

        <div class="col">
        <div class="input-group mb-3">
            <span class="input-group-text" >To</span>
            <input type="date" class="form-control">
            
        </div>
        </div>

        
    </div>
    <div class="p-3">
        <button type="submit" class="btn btn-success">FIlter</button>
    </div>
</div>

@endsection