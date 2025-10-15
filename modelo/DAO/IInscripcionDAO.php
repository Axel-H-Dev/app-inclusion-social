<?php
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
interface IInscripcionDAO {
    public function crear(Inscripcion $inscripcion);
    public function obtenerPorId($id);
    public function obtenerPorUsuario($id_usuario);
    public function obtenerPorCurso($id_curso);
    public function actualizar(Inscripcion $inscripcion);
    public function verificarInscripcion($id_usuario, $id_curso);
    public function actualizarProgreso($id_inscripcion, $progreso);
    public function completarCurso($id_inscripcion);
}
