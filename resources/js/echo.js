// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;
// // window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// window.Echo = new Echo({
//     broadcaster: "pusher",
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     forceTLS: true,
//     wsHost: import.meta.env.VITE_PUSHER_HOST,
//     wsPort: import.meta.env.VITE_PUSHER_PORT,
//     wssPort: import.meta.env.VITE_PUSHER_PORT,
//     enabledTransports: ["ws", "wss"],
//     auth: {
//         headers: {
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
//         },
//     },
// });


// window.dispatchEvent(new Event('echo:ready'));


// // window.Echo = new Echo({
// //     broadcaster: 'pusher',
// //     key: pusherKey,
// //     cluster: pusherCluster,
// //     wsHost: import.meta.env.VITE_PUSHER_HOST,
// //     wsPort: import.meta.env.VITE_PUSHER_PORT,
// //     wssPort: import.meta.env.VITE_PUSHER_PORT,
// //     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
// //     enabledTransports: ['ws', 'wss'],
// // });



import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    // Do NOT set wsHost / wsPort / wssPort when using Pusher Cloud
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                ?.content,
        },
    },
});

window.dispatchEvent(new Event('echo:ready'));
console.log('Echo ready');
