export default function (router, routes, capability) {
    routes.map(route => {
        if (capability === 'administrator' || (Array.isArray(route.meta.capabilities) && route.meta.capabilities.includes(capability))) {
            //console.log(route);
            router.addRoute(route);
        }
    });
}