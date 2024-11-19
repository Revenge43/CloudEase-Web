const quill = new Quill('#editor', {
    theme: 'snow'
});

// Handle form submission to populate the hidden input with Quill content
document.querySelector('form').onsubmit = function () {
    document.querySelector('input[name=description]').value = quill.root.innerHTML;
};

const baseUrl = 'http://localhost/cloudease';

quill.on('text-change', function (delta, oldDelta, source) {
    if (source === 'user') {
        delta.ops.forEach(op => {
            if (op.insert && typeof op.insert === 'object' && op.insert.link) {
                // Check if the link lacks a protocol
                if (!/^https?:\/\//i.test(op.insert.link)) {
                    const fullLink = `${baseUrl}/${op.insert.link.replace(/^\/+/, '')}`;
                    // Apply the full URL
                    quill.format('link', fullLink);
                }
            }
        });
    }
});