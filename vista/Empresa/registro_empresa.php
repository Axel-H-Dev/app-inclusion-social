<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro Empresa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <nav class="navbar is-light">
        <div class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="../../index.php">Login</a>
                <a class="navbar-item" href="../Usuario/registro_usuario.php">Registrarse Usuario</a>
            </div>
        </div>
    </nav>

    <section class="section">
        <div class="container">
            <div class="box">
                <h2 class="title is-4 has-text-centered">Registro de Empresa</h2>
                <form method="POST" action="/inclusion_laboral2/controlador/AuthControllerEmpresa.php">

                   
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">Nombre de la empresa</label>
                                <div class="control">
                                    <input class="input" type="text" name="nombre_empresa" placeholder="Nombre de la empresa"
                                    pattern="[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ ]{3,50}" required>
                                </div>
                            </div>
                        </div>

                        <div class="column">
                            <div class="field">
                                <label class="label">Razón Social</label>
                                <div class="control">
                                    <input class="input" type="text" name="razon_social" placeholder="Razón Social" 
                                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,50}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">Condición Social</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select name="condicion_social" required>
                                            <option value="SRL">SRL</option>
                                            <option value="SA">SA</option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="column">
                            <div class="field">
                                <label class="label">CUIT</label>
                                <div class="control">
                                    <input class="input" type="text" name="documento" placeholder="Documento (CUIT)" 
                                    pattern="^\d{11}$" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">Calle</label>
                                <div class="control">
                                    <input class="input" type="text" name="calle" placeholder="Calle" 
                                    pattern="[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ .,-]{3,50}" required>
                                </div>
                            </div>
                        </div>

                        <div class="column">
                            <div class="field">
                                <label class="label">Número</label>
                                <div class="control">
                                    <input class="input" type="text" name="numero" placeholder="Número" 
                                     pattern="^\d{1,5}$" required>
                                </div>
                            </div>
                        </div>

                        <div class="column">
                            <div class="field">
                                <label class="label">Código Postal</label>
                                <div class="control">
                                    <input class="input" type="text" name="codigo_postal" placeholder="Código Postal"
                                        pattern="^\d{4,5}$" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">Teléfono</label>
                                <div class="control">
                                    <input class="input" type="tel" name="telefono_empresa" placeholder="Teléfono Empresa" 
                                    pattern="^\d{8,12}$" required>
                                </div>
                            </div>
                        </div>

                        <div class="column">
                            <div class="field">
                                <label class="label">País</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select name="pais" required>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Chile">Chile</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="column">
                            <div class="field">
                                <label class="label">Industria</label>
                                <div class="control">
                                    <input class="input" type="text" name="industria" placeholder="Industria" 
                                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,50}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Cantidad de empleados</label>
                        <div class="control">
                            <input class="input" type="number" name="empleados" placeholder="Cantidad de empleados" 
                            min="1" max="10000" required>
                        </div>
                    </div>

                    <hr>

                    <!-- Datos Usuario -->
                    <h3 class="title is-5 has-text-centered">Información del Usuario</h3>

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">Nombre</label>
                                <div class="control">
                                    <input class="input" type="text" name="nombre_usuario" placeholder="Nombre Usuario" 
                                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,30}" required>
                                </div>
                            </div>
                        </div>

                        <div class="column">
                            <div class="field">
                                <label class="label">Apellido</label>
                                <div class="control">
                                    <input class="input" type="text" name="apellido_usuario" placeholder="Apellido" 
                                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,30}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">Tipo Documento</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select name="tipo_documento" required>
                                            <option value="CUIT">CUIT</option>
                                            <option value="DNI">DNI</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="column">
                            <div class="field">
                                <label class="label">Documento</label>
                                <div class="control">
                                    <input class="input" type="text" name="numero_documento" placeholder="Número de documento" 
                                    pattern="\d{7,11}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">Teléfono</label>
                                <div class="control">
                                    <input class="input" type="tel" name="telefono_usuario" placeholder="Teléfono del usuario" 
                                    pattern="[0-9]{8,12}" required>
                                </div>
                            </div>
                        </div>

                        <div class="column">
                            <div class="field">
                                <label class="label">Email</label>
                                <div class="control">
                                    <input class="input" type="email" name="email_usuario" placeholder="Email" 
                                    pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">Contraseña</label>
                                <div class="control">
                                    <input class="input" type="password" name="clave_usuario" placeholder="Contraseña" 
                                    pattern=".{6,}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="control has-text-centered mt-4">
                        <button class="button is-dark" type="submit" name="btnregistrarempresa" value="Ok">Registrar Empresa</button>
                    </div>

                </form>
            </div>
        </div>
    </section>
</body>

</html>


