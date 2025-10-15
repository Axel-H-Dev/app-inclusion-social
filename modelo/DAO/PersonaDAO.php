<?php


if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header("HTTP/1.1 403 Forbidden");
    exit("Acceso prohibido.");
}
require_once __DIR__ . '/../Conexion.php';

class PersonaDAO {
    private $pdo;

    public function __construct() {
        $this->pdo = (new Conexion())->getConexion();
    }

public function registrar(Persona $persona) {
    $sql = "INSERT INTO persona (id_persona, id_tipodiscapacidad, cv, certificaciones)
            VALUES (?, ?, ?, ?)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        $persona->getIdUsuario(),
        $persona->getIdTipodiscapacidad(),
        $persona->getCv(),
        $persona->getCertificaciones()
    ]);
}
public function actualizarCv($idPersona, $cv) {
    $sql = "UPDATE persona SET cv = :cv WHERE id_persona = :id";
    $stmt = $this->pdo->prepare($sql);

    
    $stmt->bindValue(':cv', $cv, PDO::PARAM_LOB);
    $stmt->bindValue(':id', $idPersona, PDO::PARAM_INT);

    return $stmt->execute();
}



public function obtenerCv($idPersona) {
    $sql = "SELECT cv FROM persona WHERE id_persona = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id' => $idPersona]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && is_resource($row['cv'])) {
        
        return stream_get_contents($row['cv']);
    }

    return $row['cv'] ?? null;
}

}
