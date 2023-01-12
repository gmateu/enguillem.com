import { registerBlockType } from '@wordpress/blocks';
import {TextControl} from '@wordpress/components';

registerBlockType('pgb/basic-block', {
	title: 'Basic Block',
	description: 'Este bloque no tiene ninguna funcionalidad, simplemente es un Hello World.',
	icon: 'smiley',
	category: 'layout',
    keywords: [ 'wordpress', 'gutenberg', 'platzigift'],
    attributes: {
		content: {
			type: 'string',
			default: 'Hello world'
		}
	},
	edit: (props) => {
		const { attributes: { content }, setAttributes, className,isSelected } = props;
		const handlerOnChangeInput = (event) => {
			setAttributes( { content: event.target.value } )
		}
		return <TextControl 
					label = "Complete el campo"
					class={ className }
					value={ content }
					onChange={ handlerOnChangeInput }
				/>
	},
	save: (props) => <h2 class={ props.className }>{ props.attributes.content }</h2>
});