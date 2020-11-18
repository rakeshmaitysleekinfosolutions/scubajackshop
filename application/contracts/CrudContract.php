<?php
namespace Application\Contracts;

interface CrudContract {
    public function index();
    public function create();
    public function store();
    public function edit($id);
    public function delete();
    public function validateForm();
    public function setData();
    public function onLoadDatatableEventHandler();
    public function onChangeStatusEventHandler();
}