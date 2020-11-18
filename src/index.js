import React from 'react';
import ReactDOM from 'react-dom';
import AppComponent from "./components/App";
const render = () => {
      return ReactDOM.render(<AppComponent></AppComponent>, document.getElementById('app')
);
}
render();

