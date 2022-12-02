import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import reportWebVitals from './reportWebVitals';
import Grouplist from "./components/Grouplist";
import Postlist from "./components/Postlist";

const root1 = ReactDOM.createRoot(document.getElementById('learningcompanions_groups-content'));
const root2 = ReactDOM.createRoot(document.getElementById('learningcompanions_chat-content'));
if (typeof learningcompanions_groupid === "undefined") {
    var learningcompanions_groupid = 1;
}
root1.render(
  <React.StrictMode>
     <Grouplist activeGroupid={learningcompanions_groupid}/>
  </React.StrictMode>
);
root2.render(
    <React.StrictMode>
        <Postlist activeGroupid={learningcompanions_groupid}/>
    </React.StrictMode>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
