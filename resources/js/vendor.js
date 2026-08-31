

// Only subscribe if we have an admin ID
if (window.loggedInUserId) {
    const channelName = `digital-files.user.${window.loggedInUserId}`;
    window.Echo.private(channelName)
        .listen('.digital-file.status.updated', function (event) {
            // Find any element that has the id, then climb to the card
            const el = $(`#digitalPreviewContainer [data-file-id="${event.id}"]`)
                .closest('.dz-preview, .file-card');

            // check if theirs an element to found to update
            if (el.length === 0) {
                return;
            }

            // update the UI for this file based on the new status
            updateFileUI(el, event.status);

        })
        .error((error) => {
            console.error('Channel subscription error:', error);
        });
} else {
    console.warn('No loggedInUserId – skipping private channel subscription');
}
