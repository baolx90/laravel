import {createContext, useContext, useState} from "react";
import createApp from "@shopify/app-bridge";
import {AppLink, NavigationMenu} from '@shopify/app-bridge/actions';
import { getSessionToken, authenticatedFetch } from "@shopify/app-bridge/utilities";

const searchParams = new URLSearchParams(document.location.search)
const host = searchParams.get("host") || window.__SHOPIFY_DEV_HOST;

window.__SHOPIFY_DEV_HOST = host;


try {

const appConfig = {
  host,
  apiKey: import.meta.env.VITE_SHOPIFY_API_KEY,
  forceRedirect: true,
};
  const app = createApp(appConfig);
  console.log(app);
} catch (error) {
  console.log('bao');
  
}

// console.log(appConfig);

// const itemsLink = AppLink.create(app, {
//     label: 'Items',
//     destination: '/items',
// });
// const settingsLink = AppLink.create(app, {
//     label: 'Settings',
//     destination: '/settings',
// });
// // create NavigationMenu with no active links
// const navigationMenu = NavigationMenu.create(app, {
//     items: [itemsLink, settingsLink],
// });

// const sessionToken = await getSessionToken(app);

const StateContext = createContext({
  currentUser: null,
  token: null,
  notification: null,
  setUser: () => {},
  setToken: () => {},
  setNotification: () => {}
})

export const AuthContext = ({children}) => {
  const [user, setUser] = useState({});
  const [token, _setToken] = useState(localStorage.getItem('ACCESS_TOKEN'));
  const [notification, _setNotification] = useState('');

  const setToken = (token) => {
    _setToken(token)
    if (token) {
      localStorage.setItem('ACCESS_TOKEN', token);
    } else {
      localStorage.removeItem('ACCESS_TOKEN');
    }
  }

  const setNotification = message => {
    _setNotification(message);

    setTimeout(() => {
      _setNotification('')
    }, 5000)
  }
  // console.log(appConfig)
  return (
    <StateContext.Provider value={{
      user,
      setUser,
      token,
      setToken,
      notification,
      setNotification
    }}>
      {children}
    </StateContext.Provider>
  );
}

export const useStateContext = () => useContext(StateContext);