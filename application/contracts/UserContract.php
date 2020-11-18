<?php
namespace Application\Contracts;

interface UserContract {
    public function index();
    public function create();
    public function store();
    public function edit($id);
    public function show($id);
    public function delete();
    public function validateForm();
    public function form();
    public function onLoadDatatableEventHandler();
    public function onChangeStatusEventHandler();
}