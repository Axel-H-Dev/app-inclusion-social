<?php
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
interface ICursoDAO {
    public function crear(Curso $curso);
    public function obtenerPorId($id);
    public function obtenerTodos();
    public function obtenerPorEmpresa($id_empresa);
    public function actualizar(Curso $curso);
    public function desactivar($id_curso);
    public function obtenerActivos();
}
