import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'

import './index.css'
import AudioPlayer from '../../src'

class Player extends Component {
  constructor() {
    super()

    this.state = {
      songs: [],
      initilized: false
    }
  }

  componentWillMount() {
    this.initilizeSongs()
  }

  initilizeSongs = async () => {
    try {
      let response = await axios('http://localhost:8000/songs/all/json')
      let data = response.data 

      console.log(data)

      this.setState({ 
        songs: data,
        initilized: true
      })
    } catch(err) {
      console.log("Whooops something went wrong!")
    }
  }

  render() {
    // fetch the ongs 
    const { songs, initilized } = this.state 

    return (
      <div>
        {
          initilized 
          &&
          <AudioPlayer songs={songs} />
        }
      </div>
    )
  }
}

ReactDOM.render(
  <div className="wrapper">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,400,700" rel="stylesheet" type="text/css" />
    
    <Player />
  </div>,
  document.querySelector('#demo'),
);
