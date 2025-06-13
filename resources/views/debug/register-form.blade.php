<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depuración de Formulario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .input-group {
            display: flex;
        }
        .input-group-text {
            padding: 8px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-left: none;
            border-radius: 0 4px 4px 0;
        }
        .error {
            color: red;
            margin-top: 5px;
        }
        .debug-section {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Depuración del Formulario de Registro</h1>
        
        <form id="debugForm" method="POST" action="#">
            @csrf
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <div class="input-group">
                    <input 
                        type="text" 
                        id="email" 
                        name="email" 
                        placeholder="nombreusuario" 
                        value="{{ old('email') }}">
                    <span class="input-group-text">@ventasfix.cl</span>
                </div>
                <div id="emailError" class="error"></div>
            </div>
            
            <button type="button" id="checkButton">Verificar</button>
        </form>
        
        <div class="debug-section">
            <h2>Información de Depuración</h2>
            <div id="debugInfo"></div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailField = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            const debugInfo = document.getElementById('debugInfo');
            const checkButton = document.getElementById('checkButton');
            
            function updateDebugInfo() {
                const value = emailField.value;
                let debugText = `
                    <p><strong>Valor actual:</strong> "${value}"</p>
                    <p><strong>Longitud:</strong> ${value.length}</p>
                    <p><strong>Contiene @:</strong> ${value.includes('@') ? 'Sí' : 'No'}</p>
                    <p><strong>Coincide con regex [a-zA-Z0-9._-]+:</strong> ${/^[a-zA-Z0-9._-]+$/.test(value) ? 'Sí' : 'No'}</p>
                    <p><strong>Caracteres especiales detectados:</strong> `;
                
                let specialChars = [];
                for (let i = 0; i < value.length; i++) {
                    const char = value[i];
                    if (!/[a-zA-Z0-9._-]/.test(char)) {
                        specialChars.push(`"${char}" en posición ${i+1}`);
                    }
                }
                
                debugText += specialChars.length ? specialChars.join(', ') : 'Ninguno';
                debugText += '</p>';
                
                debugInfo.innerHTML = debugText;
            }
            
            // Validar cuando el usuario escribe
            emailField.addEventListener('input', function() {
                emailError.textContent = '';
                updateDebugInfo();
                
                const value = emailField.value;
                
                if (value.includes('@')) {
                    emailError.textContent = 'No incluya el símbolo @ en el nombre de usuario, ya se agrega automáticamente.';
                } else if (!value.length) {
                    emailError.textContent = 'Este campo es obligatorio.';
                } else if (!/^[a-zA-Z0-9._-]+$/.test(value)) {
                    emailError.textContent = 'El nombre de usuario solo puede contener letras, números, puntos, guiones y guiones bajos.';
                }
            });
            
            // Botón de verificación
            checkButton.addEventListener('click', function() {
                updateDebugInfo();
                
                const value = emailField.value;
                emailError.textContent = '';
                
                if (!value.length) {
                    emailError.textContent = 'Este campo es obligatorio.';
                } else if (value.includes('@')) {
                    emailError.textContent = 'No incluya el símbolo @ en el nombre de usuario, ya se agrega automáticamente.';
                } else if (!/^[a-zA-Z0-9._-]+$/.test(value)) {
                    emailError.textContent = 'El nombre de usuario solo puede contener letras, números, puntos, guiones y guiones bajos.';
                } else {
                    emailError.textContent = 'El formato es válido.';
                    emailError.style.color = 'green';
                }
            });
            
            // Inicializar
            updateDebugInfo();
        });
    </script>
</body>
</html> 