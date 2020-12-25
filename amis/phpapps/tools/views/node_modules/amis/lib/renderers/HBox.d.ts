import React from 'react';
import { RendererProps } from '../factory';
import { Schema } from '../types';
import { BaseSchema, SchemaObject } from '../Schema';
export declare type HBoxColumnObject = {
    /**
     * 列上 CSS 类名
     */
    columnClassName?: string;
    /**
     * 宽度
     */
    width?: number | string;
    /**
     * 高度
     */
    height?: number | string;
    /**
     * 其他样式
     */
    style?: {
        [propName: string]: any;
    };
};
export declare type HBoxColumn = HBoxColumnObject & SchemaObject;
/**
 * Hbox 水平布局渲染器。
 * 文档：https://baidu.gitee.io/amis/docs/components/hbox
 */
export interface HBoxSchema extends BaseSchema {
    /**
     * 指定为each展示类型
     */
    type: 'hbox';
    columns: Array<HBoxColumn>;
}
export interface HBoxProps extends RendererProps, HBoxSchema {
    className: string;
    itemRender?: (item: any, key: number, length: number, props: any) => JSX.Element;
}
export default class HBox extends React.Component<HBoxProps, object> {
    static propsList: Array<string>;
    static defaultProps: Partial<HBoxProps>;
    renderChild(region: string, node: Schema): JSX.Element;
    renderColumn(column: HBoxColumn, key: number, length: number): JSX.Element | null;
    renderColumns(): (JSX.Element | null)[];
    render(): JSX.Element;
}
export declare class HBoxRenderer extends HBox {
}
