/**
 *  Custom Authentication Validation
 */

'use strict';
const formAuthentication = document.querySelector('#formAuthentication');

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // Form validation for Add new record
    if (formAuthentication) {
      const fv = FormValidation.formValidation(formAuthentication, {
        fields: {
          username: {
            validators: {
              notEmpty: {
                message: 'Por favor ingrese su nombre de usuario'
              },
              stringLength: {
                min: 6,
                message: 'El nombre de usuario debe tener más de 6 caracteres'
              }
            }
          },
          email: {
            validators: {
              notEmpty: {
                message: 'Por favor ingrese su nombre de usuario'
              },
              regexp: {
                regexp: /^[a-zA-Z0-9._-]+$/,
                message: 'El nombre de usuario solo puede contener letras, números, puntos, guiones y guiones bajos'
              },
              callback: {
                message: 'No incluya el símbolo @ en el nombre de usuario',
                callback: function(value) {
                  return !value.includes('@');
                }
              }
            }
          },
          'email-username': {
            validators: {
              notEmpty: {
                message: 'Por favor ingrese email / nombre de usuario'
              }
            }
          },
          rut: {
            validators: {
              notEmpty: {
                message: 'Por favor ingrese su RUT'
              }
            }
          },
          nombre: {
            validators: {
              notEmpty: {
                message: 'Por favor ingrese su nombre'
              }
            }
          },
          apellido: {
            validators: {
              notEmpty: {
                message: 'Por favor ingrese su apellido'
              }
            }
          },
          password: {
            validators: {
              notEmpty: {
                message: 'Por favor ingrese su contraseña'
              },
              stringLength: {
                min: 8,
                message: 'La contraseña debe tener al menos 8 caracteres'
              }
            }
          },
          'confirm-password': {
            validators: {
              notEmpty: {
                message: 'Por favor confirme su contraseña'
              },
              identical: {
                compare: function () {
                  return formAuthentication.querySelector('[name="password"]').value;
                },
                message: 'Las contraseñas no coinciden'
              }
            }
          },
          terms: {
            validators: {
              notEmpty: {
                message: 'Por favor acepte los términos y condiciones'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.mb-6'
          }),
          submitButton: new FormValidation.plugins.SubmitButton(),
          defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
          autoFocus: new FormValidation.plugins.AutoFocus()
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      });
    }
  })();
}); 