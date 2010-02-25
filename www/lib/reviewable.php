<?php
interface reviewable{
    public function getId();
    public function getSumu();
    public function getSumd();
	public function getSumut();
	public function setSumut($v);
	public function getSumdt();
	public function setSumdt($v);
	public function getTotalt();
	public function getImagen();
	public function getLongName();
	public function getVanity();
	public function getPath();
	public function getModule();
} 