import {
  mdiMenu,
  mdiClockOutline,
  mdiCloud,
  mdiCrop,
  mdiAccount,
  mdiCogOutline,
  mdiEmail,
  mdiLogout,
  mdiThemeLightDark,
  mdiGithub,
  mdiReact,
  mdiBell,
} from "@mdi/js";

import { usePage } from "@inertiajs/vue3";
import axios from 'axios';


console.log('glooooooooooooooo')


export default [
  {
    
    href: "/notificaciones",
    icon: mdiBell,
    label: "Notificaciones",
    isDesktopNoLabel: true,
    isNotification: true,
  },

  
  {
    isCurrentUser: true,
    menu: [
      {
        href:"/profile",
        icon: mdiAccount,
        label: "Mi perfil",
        to: "/profile",
      },
      {
        isDivider: true,
      },
      {
        icon: mdiLogout,
        label: "Cerrar Sesion",
        isLogout: true,
      },
      


    ],
  },
  {
    icon: mdiAccount,
    isRol: true,
  },
  {
    icon: mdiLogout,
    label: "Log out",
    isDesktopNoLabel: true,
    isLogout: true,
  },
 
];
