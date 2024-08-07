<?php

return array(

    'support_url_help' => 'Variables <code>{LOCALE}</code>, <code>{SERIAL}</code>, <code>{MODEL_NUMBER}</code>, y <code>{MODEL_NAME}</code> se pueden utilizar en su URL para que esos valores se llenen automáticamente al ver los activos - por ejemplo https://checkcoverage. pple.com/{LOCALE}/{SERIAL}.',
    'does_not_exist' => 'Fabricante inexistente.',
    'assoc_users'	 => 'Este fabricante está actualmente asociado con al menos un modelo y no se puede eliminar. Por favor, actualice sus modelos para dejar de hacer referencia a este fabricante y vuelva a intentarlo. ',

    'create' => array(
        'error'   => 'El fabricante no fue creado, por favor inténtelo de nuevo.',
        'success' => 'Fabricante creado.'
    ),

    'update' => array(
        'error'   => 'El fabricante no fue actualizado, por favor inténtelo de nuevo',
        'success' => 'Fabricante actualizado.'
    ),

    'restore' => array(
        'error'   => 'El fabricante no fue restaurado, intente de nuevo',
        'success' => 'Fabricante restaurado con éxito.'
    ),

    'delete' => array(
        'confirm'   => '¿Está seguro de que desea eliminar este fabricante?',
        'error'   => 'Ocurrió un problema eliminando el fabricante. Por favor, intente nuevamente.',
        'success' => 'El fabricante se ha eliminado correctamente.'
    )

);
