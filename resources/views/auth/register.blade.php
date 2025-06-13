<!doctype html>

<html
  lang="es"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets/') }}"
  data-template="vertical-menu-template"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Registro - VentasFix</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/form-validation.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6">
          <!-- Register Card -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-6">
                <a href="/" class="app-brand-link">
                  <span class="app-brand-text demo text-heading fw-bold h1">VentasFix</span>
                </a>
              </div>
              <!-- /Logo -->
              <h4 class="mb-1">Registro de usuario 🚀</h4>
              <p class="mb-6">Complete todos los campos para crear su cuenta</p>

              @include('components.error-message')

              <form id="formAuthentication" class="mb-6" action="{{ route('register') }}" method="POST" novalidate>
                @csrf
                <div class="mb-6">
                  <label for="rut" class="form-label">RUT</label>
                  <input
                    type="text"
                    class="form-control @error('rut') is-invalid @enderror"
                    id="rut"
                    name="rut"
                    placeholder="Ingrese su RUT sin puntos ni guión"
                    value="{{ old('rut') }}"
                    autofocus />
                  @error('rut')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-6">
                  <label for="nombre" class="form-label">Nombre</label>
                  <input
                    type="text"
                    class="form-control @error('nombre') is-invalid @enderror"
                    id="nombre"
                    name="nombre"
                    placeholder="Ingrese su nombre"
                    value="{{ old('nombre') }}" />
                  @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-6">
                  <label for="apellido" class="form-label">Apellido</label>
                  <input
                    type="text"
                    class="form-control @error('apellido') is-invalid @enderror"
                    id="apellido"
                    name="apellido"
                    placeholder="Ingrese su apellido"
                    value="{{ old('apellido') }}" />
                  @error('apellido')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-6">
                  <label for="email" class="form-label">Correo electrónico</label>
                  <div class="input-group">
                    <input 
                      type="text" 
                      class="form-control @error('email') is-invalid @enderror" 
                      id="email" 
                      name="email" 
                      placeholder="nombreusuario"
                      value="{{ old('email') }}"
                      autocomplete="off" />
                    <span class="input-group-text bg-light">@ventasfix.cl</span>
                  </div>
                  <small class="text-muted mt-1">Solo ingrese su nombre de usuario, sin incluir "@ventasfix.cl"</small>
                  @error('email')
                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                  @enderror
                </div>
                <div class="mb-6 form-password-toggle">
                  <label class="form-label" for="password">Contraseña</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control @error('password') is-invalid @enderror"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                  </div>
                  @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>

                <div class="my-8">
                  <div class="form-check mb-0 ms-2">
                    <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" id="terms-conditions" name="terms" />
                    <label class="form-check-label" for="terms-conditions">
                      Acepto la
                      <a href="javascript:void(0);">política de privacidad y términos</a>
                    </label>
                    @error('terms')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <button class="btn btn-primary d-grid w-100" type="submit">Registrarse</button>
              </form>

              <p class="text-center">
                <span>¿Ya tienes una cuenta?</span>
                <a href="/login">
                  <span>Inicia sesión</span>
                </a>
              </p>

              <div class="divider my-6">
                <div class="divider-text">o</div>
              </div>

              <div class="d-flex justify-content-center">
                <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-facebook me-1_5">
                  <i class="tf-icons ti ti-brand-facebook-filled"></i>
                </a>

                <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-twitter me-1_5">
                  <i class="tf-icons ti ti-brand-twitter-filled"></i>
                </a>

                <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-github me-1_5">
                  <i class="tf-icons ti ti-brand-github-filled"></i>
                </a>

                <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-google-plus">
                  <i class="tf-icons ti ti-brand-google-filled"></i>
                </a>
              </div>
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/custom-auth.js') }}"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom validation -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Obtener el campo de email
        const emailField = document.getElementById('email');
        
        // Desactivar la validación HTML5 predeterminada
        emailField.setAttribute('novalidate', '');
        const form = document.getElementById('formAuthentication');
        form.setAttribute('novalidate', '');
        
        // Limpiar cualquier error previo cuando el usuario comienza a escribir
        emailField.addEventListener('focus', function() {
          emailField.classList.remove('is-invalid');
          
          // Eliminar mensajes de error personalizados
          const customErrors = document.querySelectorAll('.custom-error-message');
          customErrors.forEach(error => error.remove());
        });
        
        // Validar el campo cuando se escribe
        emailField.addEventListener('input', function(e) {
          const value = e.target.value;
          
          // Verificar si contiene @
          if (value.includes('@')) {
            // Añadir clase de error
            emailField.classList.add('is-invalid');
            
            // Verificar si ya existe un mensaje de error
            let errorMessage = emailField.parentElement.parentElement.querySelector('.custom-error-message');
            
            if (!errorMessage) {
              // Crear mensaje de error
              errorMessage = document.createElement('div');
              errorMessage.className = 'invalid-feedback d-block custom-error-message';
              errorMessage.textContent = 'No incluya el símbolo @ en el nombre de usuario, ya se agrega automáticamente.';
              emailField.parentElement.parentElement.appendChild(errorMessage);
            }
          } else {
            // Quitar clase de error
            emailField.classList.remove('is-invalid');
            
            // Eliminar mensajes de error personalizados
            const customErrors = document.querySelectorAll('.custom-error-message');
            customErrors.forEach(error => error.remove());
          }
        });
      });
    </script>
    <!-- Alert Component -->
    @include('components.alert')
  </body>
</html> 