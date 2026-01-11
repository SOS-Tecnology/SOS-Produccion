// 1. Primero, importa jQuery
import $ from 'jquery';

// 2. Luego, hazlo disponible globalmente ANTES de importar cualquier otra cosa que lo necesite
window.$ = window.jQuery = $;

// 3. Ahora sí, importa Bootstrap (que ya encontrará $ disponible)
import './bootstrap';

// console.log('--- app.js se ha cargado ---');
// console.log('El tipo de $ es:', typeof $);