const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { compose } = wp.compose;
const { withSelect, withDispatch } = wp.data;

const MyComponentBase = ({ createNotice, blocks, className }) => {
    const triggerNotice = (type) => {
        createNotice(type, __('Hello, Notices Data!', 'gwg'));
    }
    return (
        <div className={className}>
            <p>{__('Functional Component', 'gwg')}</p>

            <ul>
                <li><a onClick={() => triggerNotice('info')}>Trigger info notice</a></li>
                <li><a onClick={() => triggerNotice('error')}>Trigger error notice</a></li>
                <li><a onClick={() => triggerNotice('warning')}>Trigger warning notice</a></li>
                <li><a onClick={() => triggerNotice('success')}>Trigger success notice</a></li>
            </ul>

            <ul>
                {blocks.map(block => <li>{block.name}</li>)}
            </ul>
        </div>
    );
}

const applyWithSelect = withSelect(select => {
    const { getBlocks } = select('core/editor');
    return { blocks: getBlocks() };
});

const applyWithDispatch = withDispatch(dispatch => {
    return { createNotice } = dispatch('core/notices');
});

const MyComponent = compose(
    applyWithSelect,
    applyWithDispatch,
)(MyComponentBase);

registerBlockType('gwg/esnext-data', {
    title: __('Get With Gutenberg - ESNext Data', 'gwg'),
    category: 'common',

    edit(props) {
        return <MyComponent {...props} />;
    },

    save(props) {
        return <p className={props.className}>{__('Hello saved content.', 'gwg')}</p>;
    },
});