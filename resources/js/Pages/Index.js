import React, {useState} from 'react'
import Layout from './Layout'
import { usePage } from '@inertiajs/inertia-react'
import { Inertia } from '@inertiajs/inertia'


const Left = ({data}) =>{
	return(
		<div className="card shadow mt-3" style={{width:'90%'}}>
      <div className="card-body">
        <div className="row no-gutters align-items-center">
          <div className="col mr-2">
            <div className=" text-primary mb-1">
              <p>{data.text}
              </p>
              <hr/>
              <p className="text-small">{data.date} - {data.clock}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
	)
}
const Right = ({data}) =>{
	return(
		<div className="card shadow ml-auto mt-3" style={{width:'90%'}}>
      <div className="card-body">
        <div className="row no-gutters align-items-center">
          <div className="col mr-2">
            <div className="text-primary mb-1">
              <p>
              {data.text}
              </p>
              <hr/>
              <p className="text-small">{data.date} - {data.clock}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
	)
}

export default function Welcome({name, id, chats}) {
	const { user } = usePage().props
	const [text, setText] = useState('')
	const kirim = () =>{
		document.getElementById('text').value = ''
		const data = {text, id}
		Inertia.post('/',data)
	}
	if(id!=undefined){
	  return (
	    <Layout>
	      <div id="content">
	        <nav className="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
	          
	          <ul className="navbar-nav mr-auto">
	            <li className="nav-item dropdown no-arrow">
	              <a className="nav-link" href="#" id="userDropdown">
	                <img className="img-profile rounded-circle" src="/img/undraw_profile.svg" />
	                <span className="ml-2 text-gray-600 small">{name}</span>
	              </a>
	              
	            </li>
	          </ul>
	        </nav>
	        {/* End of Topbar */}
	        {/* Begin Page Content */}
	        <div className="container">
	          {chats.map((data)=>{
	          	if(data.from==user.id){
	          		return <Right data={data} />
	          	}else{
	          		return <Left data={data} />
	          	}
	          })}
	          
	        </div>
	        <div className="container bg-white py-2" style={{
	        	position:'fixed',
	        	bottom:'0px',
	      	}}>
	        	<div className="row">
	        		<div className="col-auto">
	        			<textarea type="text" className="form-control" style={{width:'600px'}} id='text' onChange={(e)=>setText(e.target.value)}></textarea>
	        		</div>
	        		<div className="col-auto">
	        			<button type="button" className="btn btn-primary" onClick={kirim}>Kirim</button>
	        		</div>
	        	</div>
	        </div>
	        {/* /.container-fluid */}
	      </div>
	    </Layout>
	  )
	}else{
		return (
	    <Layout>
	      <div id="content">
	        <nav className="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
	          
	          <ul className="navbar-nav mr-auto">
	            <li className="nav-item dropdown no-arrow">
	              <a className="nav-link" href="#" id="userDropdown">
	                <img className="img-profile rounded-circle" src="/img/undraw_profile.svg" />
	                <span className="ml-2 d-none d-lg-inline text-gray-600 small">{name}</span>
	              </a>
	              
	            </li>
	          </ul>
	        </nav>
	      </div>
	    </Layout>
	  )
	}
}