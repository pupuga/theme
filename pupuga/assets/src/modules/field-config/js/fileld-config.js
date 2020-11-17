import * as CodeMirror from 'codemirror/lib/codemirror';
import 'codemirror/lib/codemirror.css';
import 'codemirror/mode/xml/xml';
import 'codemirror/mode/css/css';
import 'codemirror/mode/htmlmixed/htmlmixed';

document.addEventListener("DOMContentLoaded", function (event) {
    let textarea = document.querySelectorAll('.pupuga-field--config textarea, textarea.pupuga-field--config, .code-mirror-field');
    if (textarea.length > 0) {
        for (let i = 0; i < textarea.length; i++) {
            textarea[i].addEventListener('click', function (event) {
                CodeMirror.fromTextArea(this, {
                    lineNumbers: true,
                    lineWrapping: true,
                    mode: this.getAttribute('data-type') || "xml"
                });
            });
        }
    }
});
