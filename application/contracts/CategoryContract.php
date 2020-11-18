<?php
namespace Application\Contracts;

interface CategoryContract {
    public function index();
    public function create();
    public function store();
    public function edit($id);
    public function show($id);
    public function delete();
    public function validateForm();
    public function getData();
    public function onLoadDatatableEventHandler();
    public function onClickStatusEventHandler();
}