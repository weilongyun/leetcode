import React from 'react';
import { RendererProps } from '../factory';
import { BaseSchema } from '../Schema';
/**
 * JSON 数据展示控件。
 * 文档：https://baidu.gitee.io/amis/docs/components/json
 */
export interface JsonSchema extends BaseSchema {
    /**
     * 指定为Json展示类型
     */
    type: 'json' | 'static-json';
    /**
     * 默认展开的级别
     */
    levelExpand?: number;
    /**
     * 是否隐藏根节点
     */
    hideRoot?: boolean;
    /**
     * 支持从数据链取值
     */
    source?: string;
}
export interface JSONProps extends RendererProps, JsonSchema {
    levelExpand: number;
    className?: string;
    placeholder?: string;
    jsonTheme: string;
    hideRoot?: boolean;
    source?: string;
}
export declare class JSONField extends React.Component<JSONProps, object> {
    static defaultProps: Partial<JSONProps>;
    valueRenderer(raw: any): JSX.Element;
    shouldExpandNode: (keyName: any, data: any, level: any) => boolean;
    render(): JSX.Element;
}
export declare class JSONFieldRenderer extends JSONField {
}
