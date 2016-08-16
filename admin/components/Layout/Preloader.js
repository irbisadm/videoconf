import React from 'react';
import s from './Preloader.css';
import {connect} from 'react-redux';

class Preloader extends React.Component{
    componentDidMount() {
        if(typeof this.refs.preloader != undefined)
            window.componentHandler.upgradeElement(this.refs.preloader);
    }

    componentWillUnmount() {
        if(typeof this.refs.preloader != undefined)
            window.componentHandler.downgradeElements(this.refs.preloader);
    }

    render(){
        return(<div className={s.preloader+" mdl-progress mdl-js-progress mdl-progress__indeterminate"}
                    ref="preloader"
                    style={{display:((this.props.async_inprogress)?"block":"none")}}></div>);
    }
}

function mapStateToProps(state, ownProps) {
    return {
        async_inprogress: state.async_inprogress
    };
}

export default connect(mapStateToProps,{})(Preloader);