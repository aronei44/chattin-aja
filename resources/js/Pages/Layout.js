import React, { useEffect, useState } from 'react'
import { Link } from '@inertiajs/inertia-react'
import { Inertia } from '@inertiajs/inertia'
import { Head } from '@inertiajs/inertia-react'
import { usePage } from '@inertiajs/inertia-react'
import '/css/sb-admin-2.min.css'
import '/js/sb-admin-2.min.js'
import '/css/chat.css'


export default function Layout({ children }) {
const { users, user, csrf } = usePage().props
const handleClick = (id) =>{
  Inertia.post('/', {id,_token:csrf})
}


  return (
    <main id="page-top">
      <Head title="Chattin Aja" />
      <div id="wrapper">
          <ul className="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <Link className="sidebar-brand d-flex align-items-center justify-content-center" style={{position:'fixed',top:'0px'}} href="/">
              <div className="sidebar-brand-text mx-3">Chattin aja</div>
            </Link>
            <hr className="sidebar-divider my-0"  />
            
            <li className="nav-item py-2" style={{height:'600px',overflow:'auto',marginTop:'100px'}}>
              {users.map((pengguna)=>{
                if(pengguna.id == user.id){

                }else{

                  return(
                    <p className="nav-link" onClick={()=>handleClick(pengguna.id)} key={pengguna.id}>
                      <img className="img-profile rounded-circle" src="/img/undraw_profile.svg" />
                      <span className="ml-2">{pengguna.name}</span>  
                    </p>
                  )
                }
              })}
            </li>
            
          </ul>
          <div id="content-wrapper" className="d-flex flex-column">
            {children}
          </div>
        </div>
        <a className="scroll-to-top rounded" href="#page-top">
          <i className="fas fa-angle-up" />
        </a>
        
    </main>
  )
}